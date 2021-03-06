<?php
namespace VJmedia\Vjeventdb3\Controller;

use VJmedia\Vjeventdb3\Domain\Repository\PerformerRepository;
use VJmedia\Vjeventdb3\Domain\Model\PerformerCategory;

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
 * PerformerController
 */
class PerformerController extends \VJmedia\Vjeventdb3\Controller\AbstractController {

	/**
	 * performerRepository
	 *
	 * @var \VJmedia\Vjeventdb3\Domain\Repository\PerformerRepository
	 * @inject
	 */
	protected $performerRepository = NULL;
	
	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$performers = $this->performerRepository->findAll($this->getPerfromerCategoryFilter());
		$this->view->assign('performers', $this->performerRepository->findAll());
	}

	
	protected function getPerfromerCategoryFilter() {
		$list = $this->getArgument('performerCategories', $this->settings['performerCategoryFilter']);
		if(!$list) {
			return array();
		}
		return \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $list);
	}
	
}