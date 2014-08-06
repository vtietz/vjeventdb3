<?php

namespace VJmedia\Vjeventdb3\Controller;

use VJmedia\Vjeventdb3\Domain\ViewModel\EventOrder;
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
 * EventOrderFormController
 */
class EventOrderFormController extends \VJmedia\Vjeventdb3\Controller\AbstractController {

	/**
	 * eventRepository
	 *
	 * @var \VJmedia\Vjeventdb3\Domain\Repository\EventRepository
	 * @inject
	 */
	protected $eventRepository = NULL;
	
	/**
	 * action show
	 *
	 * @return void
	 */
	public function showAction() {
		$eventOrder = new \VJmedia\Vjeventdb3\Domain\ViewModel\EventOrder();
		$eventOrder->setEvent($this->getCurrentEvent());
		$this->view->assign('eventOrder', $eventOrder);
		$this->view->assign('events', $this->eventRepository->findAll());
		$cObjData = $this->configurationManager->getContentObject()->data;
		$this->view->assign('data', $cObjData);
	}
	
	protected function notify(\VJmedia\Vjeventdb3\Domain\ViewModel\EventOrder $eventOrder) {
		$message = $this->getMessage($eventOrder);
		$this->sendMail($this->getSetting('mail_recipient'), $this->getSetting('mail_subject'), $message, $eventOrder->getEmail());
	}
	
	protected function getMessage($eventOrder, $templateName) {
		$renderer = $this->getPlainTextEmailRenderer($templateName);
		// assign the data to it
		$renderer->assign('eventOrder', $eventOrder);
		$renderer->assign('url', $this->uriBuilder->getRequest()->getBaseUri());
		// and do the rendering magic
		return $renderer->render();
	}
	
	/**
	 * This creates another stand-alone instance of the Fluid view to render a plain text e-mail template
	 * @param string $templateName the name of the template to use
	 * @return Tx_Fluid_View_StandaloneView the Fluid instance
	 */
	protected function getPlainTextEmailRenderer($templateName = 'default') {
		$emailView = new \TYPO3\CMS\Fluid\View\StandaloneView();
		$emailView->setFormat('txt');
		$extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		$templateRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPath']);
		$templatePathAndFilename = $templateRootPath . $this->request->getControllerName().'/' . $templateName . '.txt';
		$emailView->setTemplatePathAndFilename($templatePathAndFilename);
		$emailView->assign('settings', $this->settings);
		return $emailView;
	}
	
	protected function getCurrentEvent() {
		$eventUid = $_GET['tx_vjeventdb3_eventdetail']['event'];
		$event = $this->eventRepository->findByUid($eventUid);
		return $event;
	}
	
	/**
	 * action submit
	 * @param array $eventOrder
	 * @return void
	 */
	public function submitAction($eventOrder) {
		$this->view->assign('eventOrder', $eventOrder);
		$this->view->assign('events', $this->eventRepository->findAll());
		$cObjData = $this->configurationManager->getContentObject()->data;
		$this->view->assign('data', $cObjData);
		$message = $this->getMessage($eventOrder, 'NotifyRecipient');
		$this->sendMail($this->settings['mail_recipient'], $this->settings['mail_subject'], $message, $eventOrder['email']);
	}
	
	private function validate($eventOrder) {
		
	}
	/**
	 * @param string $recipient
	 * @param string $subject
	 * @param string $message
	 * @param string $sender
	 */
	protected function sendMail($recipient, $subject, $message, $sender) {
		
		var_dump($recipient);
		var_dump($subject);
		var_dump($message);
		var_dump($sender);
		
		/*
		$message = new \TYPO3\CMS\Core\Mail\MailMessage();
		$message->setFrom(array($sender => ''));
		$message->setTo(array($recipient => ''));
		$message->setBody($message);
		$message->send();
		*/
		/*
		if($message->isSent()) {
			$this->flashMessageContainer->add('Subj');
		} else {
			$this->flashMessageContainer->add('Die Mail wurde nicht versandt.');
		}
		*/
	}
	
}

