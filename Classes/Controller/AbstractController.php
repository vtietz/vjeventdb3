<?php
namespace VJmedia\Vjeventdb3\Controller;

use VJmedia\Vjeventdb3\Domain\Repository\PerformerRepository;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 Vincent Tietz <vincent.tietz@vj-media.de>, vjmedia
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * AbstractEventListController
 */
abstract class AbstractController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * eventRepository
	 *
	 * @var \VJmedia\Vjeventdb3\Domain\Repository\EventRepository
	 * @inject
	 */
	protected $eventRepository = NULL;

	protected function setTemplatePaths($config) {
		if($partialRootPath = $config['partialRootPath']) {
			$this->view->setPartialRootPath($partialRootPath);
		}
		if($layoutRootPath = $config['layoutRootPath']) {
			$this->view->setLayoutRootPath($layoutRootPath);
		}
		if($templateRootPath = $config['templateRootPath']) {
			$this->view->setTemplateRootPath($templateRootPath);
		}
		if($templatePathAndFilname = $config['templatePathAndFilname']) {
			$templatePathAndFilname = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($templatePathAndFilname);
			$this->view->setTemplatePathAndFilename($templatePathAndFilname);
		}
	}
	
	protected function getArgument($name, $default = '') {
		if ($this->request->hasArgument($name)) {
			return $this->request->getArgument($name);
		}
		return $default;
	}
	
	protected function getSetting($key, $defaultValue = '') {
		$keys = explode('.', $key);
		$valueHolder = $this->settings;
		foreach ($keys as $key) {
			$valueHolder = $valueHolder[$key];
		}
		if($valueHolder) {
			return $valueHolder;
		}
		return $defaultValue;
	}	
	
	protected function assignPageUids() {
		$this->assignPageUidToView('showEventPage');
		$this->assignPageUidToView('listEventPage');
		$this->assignPageUidToView('showPerformerPage');
		$this->assignPageUidToView('listPerformerPage');
	}
	
	protected function assignPageUidToView($pageName) {
		if($page = $this->getSetting($pageName)) {
			$this->view->assign($pageName, $page);
		}
		else {
			$this->view->assign($pageName, $this->data->pid);
		}
	}	
	
	protected function getTimestampFromSetting($key) {
		$setting = $this->getSetting($key);
		if(!$setting) {
			return 0;
		}
		return strtotime($setting);
	}


	/**
	 * This creates another stand-alone instance of the Fluid view to render a plain text e-mail template
	 * @param string $templateName the name of the template to use
	 * @return Tx_Fluid_View_StandaloneView the Fluid instance
	 */
	protected function getPlainTextRenderer($templateName, $templatePathAndFilename = '') {
		$emailView = new \TYPO3\CMS\Fluid\View\StandaloneView();
		$emailView->setFormat('txt');
		$extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		$templateRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPath']);
		if(!$templatePathAndFilename) {
			$templatePathAndFilename = $templateRootPath . $this->request->getControllerName().'/' . $templateName . '.txt';
		}
		else {
			$templatePathAndFilename = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($templatePathAndFilename);
		}
		$emailView->setTemplatePathAndFilename($templatePathAndFilename);
		
		$partialRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['partialRootPath']);
		$emailView->setPartialRootPath($partialRootPath);
		
		$emailView->assign('settings', $this->settings);
		return $emailView;
	}
	

	/**
	 * Wrapper for dev log, in order to ease testing
	 *
	 * @param string $message Message (in english).
	 * @param integer $severity Severity: 0 is info, 1 is notice, 2 is warning, 3 is fatal error, -1 is "OK" message
	 * @return void
	 */
	protected function log($message, $severity) {
		\TYPO3\CMS\Core\Utility\GeneralUtility::devLog($message, 'vjeventdb3', $severity);
	}
	
}