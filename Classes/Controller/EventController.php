<?php
namespace VJmedia\Vjeventdb3\Controller;

use VJmedia\Vjeventdb3\Domain\Repository\DateRepository;
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
 * EventController
 */
class EventController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * eventRepository
	 *
	 * @var \VJmedia\Vjeventdb3\Domain\Repository\EventRepository
	 * @inject
	 */
	protected $eventRepository = NULL;

	/**
	 * dateRepository
	 *
	 * @var \VJmedia\Vjeventdb3\Domain\Repository\DateRepository
	 * @inject
	 */
	protected $dateRepository = NULL;
	
	/**
	 * dateService
	 *
	 * @var \VJmedia\Vjeventdb3\Service\DateService
	 */
	protected $dateService = NULL;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$startdate = date('Y-m-d', strtotime('last Monday'));
		$enddate = date('Y-m-d', strtotime('next Monday'));
		/*
		$events = $this->eventRepository->findAllInDateRange($startdate, $enddate);
		$this->view->assign('dateformat', 'l, d.m.');
		$this->view->assign('days', $this->dateService->getDaySections($startdate, $enddate));
		$this->view->assign('events', $events);
		*/
		/*
		$this->dateRepository = new DateRepository($this->objectManager);
		
		$dates = $this->dateRepository->findAllInDateRange($startDate, $endDate);
		
		$this->dateService = new \VJmedia\Vjeventdb3\Service\DateService();
		
		$this->view->assign('dates', array());
		
		*/
		
		/*
		$this->arguments['<argumentName>']
			->getPropertyMappingConfiguration()
			->forProperty('<propertyName>') // this line can be skipped in order to specify the format for all properties
			->setTypeConverterOption('TYPO3\Flow\Property\TypeConverter\DateTimeConverter', \TYPO3\Flow\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, '<dateFormat>');
		*/
		
		$this->dateRepository = $this->objectManager->get('VJmedia\\Vjeventdb3\\Domain\\Repository\\DateRepository');
		
		$this->eventRepository->findAll();
		//$this->dateRepository->findAllInDateRange($startDate, $endDate);
		$dates = $this->dateRepository->findAll();
		
		$this->view->assign('dates', $dates);
		
		$this->view->assign('days', array());
		$this->view->assign('events', array());
		
	}

	/**
	 * action show
	 *
	 * @param \VJmedia\Vjeventdb3\Domain\Model\Event $event
	 * @return void
	 */
	public function showAction(\VJmedia\Vjeventdb3\Domain\Model\Event $event) {
		$this->view->assign('event', $event);
	}

	/**
	 * action teaser
	 *
	 * @return void
	 */
	public function teaserAction() {
		
	}

}