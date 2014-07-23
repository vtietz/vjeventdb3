<?php
namespace VJmedia\Vjeventdb3\Controller;

use VJmedia\Vjeventdb3\Domain\Repository\DateRepository;
use VJmedia\Vjeventdb3\Domain\Repository\PriceCategoryRepository;
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
	 * priceCategoryRepository
	 *
	 * @var \VJmedia\Vjeventdb3\Domain\Repository\PriceCategoryRepository
	 * @inject
	 */
	protected $priceCategoryRepository = NULL;	

	/**
	 * priceRepository
	 *
	 * @var \VJmedia\Vjeventdb3\Domain\Repository\PriceRepository
	 * @inject
	 */
	protected $priceRepository = NULL;
	
	
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

		$startDateTime = $this->getStartDateTime();
		$endDateTime = $this->getEndDateTime($startDateTime);
		
		$allEventDates = $this->getAllDateEvents($startDateTime, $endDateTime);
		
		$this->getDateService()->sortDates($allEventDates);
		$this->view->assign('dates', $allEventDates);
		$this->view->assign('starttime', $startDateTime);
		$this->view->assign('endtime', $endDateTime);
				
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
		$this->view->assign('datepickerSettings', $this->getDatePickerSettings($startDateTime));
		
	}
	
	private function getDatePickerSettings(\DateTime $startDateTime) {

		$rangeSettings = $this->getCurrentDateRangeSettings();

		$datepickerSettings = array();
		$datepickerSettings['ranges'] = $this->getDatePickerRanges();
		$datepickerSettings['currentRange'] = $this->getCurrentDatePickerRange();
		$datepickerSettings['today'] = date('Y-m-d', strtotime($rangeSettings['today']));
		$datepickerSettings['previous'] = date('Y-m-d', strtotime($rangeSettings['previous'], $startDateTime->getTimestamp()));
		$datepickerSettings['next'] =  date('Y-m-d',  strtotime($rangeSettings['next'], $startDateTime->getTimestamp()));
		
		return $datepickerSettings;
		
	}
	
	private function dateCorrection(\DateTime $datetime, $timeCorrection) {
		if($correctionSettings) {
			$starttimeString = date('Y-m-d 00:00:00', strtotime($timeCorrection, $datetime->getTimestamp()));
			$datetime = new DateTime($starttimeString);
		}
		return $datetime;
	}
	
	private function getStartDateTime() {
		$rangeSettings = $this->getCurrentDateRangeSettings();
		$starttimeString = $this->getArgument('starttime',
				date('Y-m-d 00:00:00', strtotime($rangeSettings['defaultStartTime'])));
		$startDateTime = new DateTime($starttimeString);
		$startDateTime = $this->dateCorrection($startDateTime, $rangeSettings['startTimeCorrection']);
		return $startDateTime;
	}
	
	private function getEndDateTime(\DateTime $startDateTime) {
		$rangeSettings = $this->getCurrentDateRangeSettings();
		$endtimeString = $this->getArgument('endtime',
				date('Y-m-d 00:00:00', strtotime($rangeSettings['endTimeCorrection'], $startDateTime->getTimestamp())));
		$endDateTime = new DateTime($endtimeString);
		return $endDateTime;
	}
	
	private function getCurrentDateRangeSettings() {
		$range = $this->getCurrentDatePickerRange();
		return $this->settings['datepicker']['ranges'][$range];
	}
	
	private function getDatePickerRanges() {
		$datepickerranges = array();
		foreach($this->settings['datepicker']['ranges'] as $key => $range) {
			$datepickerranges[$key] = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($range['label'], ''); 
		}
		return $datepickerranges;
	}
	
	private function getCurrentDatePickerRange() {
		return $this->getArgument('currentRange', $this->settings['datepicker']['defaultRange']);
	}
	
	private function getArgument($name, $default) {
		if ($this->request->hasArgument($name)) {
			return $this->request->getArgument($name);
		}
		return $default;
	}
	
	private function getAllDateEvents($startdate, $enddate) {

		$events = $this->eventRepository->findAllInDateRange($startdate, $enddate);
		
		$allEventDates = array();
		foreach($events as $event) {
			$allEventDates = array_merge($allEventDates, $this->getDatesOfEvent($event, $startdate, $enddate));
		}
		return $allEventDates;
	}
	
	private function getDatesOfEvent(\VJmedia\Vjeventdb3\Domain\Model\Event $event, \DateTime $startdate, \DateTime $enddate) {
		
		$eventDates = $this->getDateService()->getAllDates($event->getDates(), $startdate, $enddate);
		foreach($eventDates as $date) {
			$date->setEvent($event);
			$date->setDuration($this->getDateService()->getDuration($date));
		}
		return $eventDates;
	}
	
	private function getDateService() {
		if($this->dateService == NULL)  {
			$this->dateService = new \VJmedia\Vjeventdb3\Service\DateService();
		}
		return $this->dateService;
	}
	
	/**
	 * action show
	 *
	 * @param \VJmedia\Vjeventdb3\Domain\Model\Event $event
	 * @return void
	 */
	public function showAction(\VJmedia\Vjeventdb3\Domain\Model\Event $event) {

		$this->view->assign('event', $event);

		//$starttime = date('Y-m-d', strtotime($this->settings['show']['startTime']));
		//$endtime = date('Y-m-d', strtotime($this->settings['show']['endTime']));
		
		$dates = $this->getDatesOfEvent($event);
		$this->view->assign('dates', $dates);
		$this->view->assign('nextdate', $this->getDateService()->getNextDate($dates));
		$this->view->assign('nextdates', $this->getDateService()->getNextDates($dates));
		
		$this->view->assign('prices', $prices);
		$this->view->assign('priceCategories', $this->getPriceCategories($event->getPrices()));
		
	}
	
	public function getPriceCategories($prices) {
		$priceCategories = array();
		foreach ($prices as $price) {
			$cuid = '';
			if($price->getPriceCategory()) {
				$cuid = $price->getPriceCategory()->getUid();
			}
			if(!$priceCategories[$cuid]) {
				$priceCategories[$cuid] = array();
				$priceCategories[$cuid]['category'] = $price->getPriceCategory();
				$priceCategories[$cuid]['prices'] = array();
			}
			$priceCategories[$cuid]['prices'][] = $price;
		}
		$compare = function($a, $b) {
			return $a['category']->getSorting() > $b['category']->getSorting() ? -1 : 1;
		};
		usort($priceCategories, $compare);
		return $priceCategories;
	}
	
	/**
	 * action teaser
	 *
	 * @return void
	 */
	public function teaserAction() {
		
	}

}