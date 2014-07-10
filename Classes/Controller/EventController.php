<?php
namespace VJmedia\Vjeventdb3\Controller;

use VJmedia\Vjeventdb3\Domain\Repository\DateRepository;
use VJmedia\Vjeventdb3\Service\DateService;
use VJmedia\Vjeventdb3\Domain\ViewModel\YearSectionView;
use VJmedia\Vjeventdb3\Domain\ViewModel\MonthSectionView;
use VJmedia\Vjeventdb3\Domain\ViewModel\DaySectionView;
use DateTime;
use VJmedia\Vjeventdb3\Service\DateUtils;

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
		
		$startdate = date('Y-m-d', strtotime('first day of this month'));
		$enddate = date('Y-m-d', strtotime('last day of this month'));
		
		$events = $this->eventRepository->findAllInDateRange($startdate, $enddate);
		
		$this->dateService = new \VJmedia\Vjeventdb3\Service\DateService();
		$allEventDates = array();
		foreach($events as $event) {
			$eventDates = $event->getDates();
			foreach($eventDates as $date) {
				$date->setEvent($event);
				$date->setDuration($this->dateService->getDuration($date));
			}
			$allEventDates = array_merge($allEventDates, 
					$this->dateService->getAllDates($eventDates, new DateTime($startdate), new DateTime($enddate)));
		}
		$this->dateService->sortDates($allEventDates);
		$this->view->assign('dates', $allEventDates);

		$years = array();
		$year = null;
		$month = null;
		$day = null;
		foreach ($allEventDates as $date) {
			
			if($year == null || $year->getDate()->format('Y') != $date->getStartDate()->format('Y')) {
				$year = new \VJmedia\Vjeventdb3\Domain\ViewModel\YearSectionView();
				$year->setDate($date->getStartDate());
				$years[] = &$year;
				$month = null;
			}
			
			if($month == null || $month->getDate()->format('m') != $date->getStartDate()->format('m')) {
				$month = new \VJmedia\Vjeventdb3\Domain\ViewModel\MonthSectionView();
				$month->setDate($date->getStartDate());
				$year->addMonth($month);
				$day = null;
			}

			if($day == null || $day->getDate()->format('d') != $date->getStartDate()->format('d')) {
				$day = new \VJmedia\Vjeventdb3\Domain\ViewModel\DaySectionView();
				$day->setDate($date->getStartDate());
				$day->addDate($date);
				$month->addDay($day);
			}
		}

		$this->view->assign('years', $years);
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