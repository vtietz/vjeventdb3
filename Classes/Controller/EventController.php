<?php
namespace VJmedia\Vjeventdb3\Controller;

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
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		
		echo "hi";

		
		$startdate = date('Y-m-d', strtotime("last Monday"));
		$enddate = date('Y-m-d', strtotime("next Monday"));
		
		echo $startdate;
		echo $enddate;
		$events = $this->eventRepository->findAllInDateRange($startdate, $enddate);
		
		/*
		$events = $this->eventRepository->findAll();
		*/
		
		//$events = $this->eventRepository->findAll();
		$this->view->assign('events', $events);
		
		
	}

	/**
	 * action show
	 *
	 * @param \VJmedia\Vjeventdb3\Domain\Model\Event $event
	 * @return void
	 */
	public function showAction(\VJmedia\Vjeventdb3\Domain\Model\Event $event) {

		echo "hi";
		var_dump($event->getDates());
		
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