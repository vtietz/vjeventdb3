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
	 * eventCategoryRepository
	 *
	 * @var \VJmedia\Vjeventdb3\Domain\Repository\EventCategoryRepository
	 * @inject
	 */
	protected $eventCategoryRepository = NULL;
	
	/**
	 * ageCategoryRepository
	 *
	 * @var \VJmedia\Vjeventdb3\Domain\Repository\AgeCategoryRepository
	 * @inject
	 */
	protected $ageCategoryRepository = NULL;
	
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
				$years[] = $year;
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
				$month->addDay($day);
			}
			$day->addDate($date);
			
		}

		
		$this->view->assign('years', $years);
		$this->view->assign('datepickerSettings', $this->getDatePickerSettings($startDateTime));

		$cObjData = $this->configurationManager->getContentObject()->data;
		$this->view->assign('data', $cObjData);
		
	}
	
	private function getDatePickerSettings(\DateTime $startDateTime) {

		$rangeSettings = $this->getCurrentDateRangeSettings();

		$datepickerSettings = array();
		$datepickerSettings['ranges'] = $this->getDatePickerRanges();
		$datepickerSettings['currentRange'] = $this->getCurrentDatePickerRange();
		$datepickerSettings['today'] = date('Y-m-d', strtotime($rangeSettings['today']));
		$datepickerSettings['previous'] = date('Y-m-d', strtotime($rangeSettings['previous'], $startDateTime->getTimestamp()));
		$datepickerSettings['next'] =  date('Y-m-d',  strtotime($rangeSettings['next'], $startDateTime->getTimestamp()));
		$datepickerSettings['regional'] = $this->settings['datepicker']['regional'];
		
		return $datepickerSettings;
		
	}
	
	private function dateCorrection(\DateTime $datetime, $timeCorrection) {
		if($correctionSettings) {
			$starttimeString = date('Y-m-d 00:00:00', strtotime($timeCorrection, $datetime->getTimestamp()));
			$datetime = new DateTime($starttimeString);
		}
		return $datetime;
	}
	
	private function getStartTimeFromArguments($rangeSettings) {
		
		$starttimeString = $this->getArgument('starttime',
				date('Y-m-d 00:00:00', strtotime($rangeSettings['defaultStartTime'])));
		$startDateTime = new DateTime($starttimeString);
		
		if($this->getArgument('nav') == 'today') {
			$starttimeString = date('Y-m-d', strtotime($rangeSettings['today']));
		}
		elseif($this->getArgument('nav') == 'next') {
			$starttimeString = date('Y-m-d',  strtotime($rangeSettings['next'], $startDateTime->getTimestamp()));
		}
		elseif($this->getArgument('nav') == 'previous') {
			$starttimeString = date('Y-m-d', strtotime($rangeSettings['previous'], $startDateTime->getTimestamp()));
		}
		
		return new DateTime($starttimeString);
		
	}
	
	private function getStartDateTime() {
		$rangeSettings = $this->getCurrentDateRangeSettings();
		$startDateTime = $this->getStartTimeFromArguments($rangeSettings);
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
		return $this->getArgument('currentrange', $this->settings['datepicker']['defaultRange']);
	}
	
	private function getArgument($name, $default = '') {
		if ($this->request->hasArgument($name)) {
			return $this->request->getArgument($name);
		}
		return $default;
	}
	
	private function getEventCategoryFilter() {
		$list = $this->getArgument('eventCategories', $this->settings['eventCategoryFilter']);
		if(!$list) {
			return array();
		}
		return \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $list);
	}

	private function getAgeCategoryFilter() {
		$list = $this->getArgument('ageCategories', $this->settings['ageCategoryFilter']);
			if(!$list) {
			return array();
		}
		return \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $list);
	}
	
	
	private function getAllDateEvents($startDateTime, $endDateTime) {

		$events = $this->eventRepository->findAllInDateRange(
					$startDateTime, 
					$endDateTime, 
					$this->getEventCategoryFilter(), 
					$this->getAgeCategoryFilter()
		);
		
		
		$allEventDates = array();
		foreach($events as $event) {
			$datesOfEvent = $this->getDatesOfEvent($event, $startDateTime, $endDateTime);
			$allEventDates = array_merge($allEventDates, $datesOfEvent);
		}
		return $allEventDates;
		
	}
	
	private function getDatesOfEvent(\VJmedia\Vjeventdb3\Domain\Model\Event $event, \DateTime $startDateTime, \DateTime $endDateTime, $maxItemsPerDate = 50) {
		
		$eventDates = $this->getDateService()->getAllDates($event->getDates(), $startDateTime, $endDateTime, $maxItemsPerDate);
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
	
	private function getDateTime($strtotime, $starttime = 0) {
		if(!$strtotime) {
			return new DateTime("0000-00-00");
		}
		return $this->getDateTimeFromTimestamp(strtotime($strtotime, $starttime));
	}
	
	private function getDateTimeFromTimestamp($timestamp) {
		if($timestamp == 0) {
			return new DateTime("0000-00-00");
		} 
		$dateString = date('Y-m-d', $timestamp);
		return new DateTime($dateString);		
	}
	
	private function getTimestampFromSetting($key) {
		$setting = $this->getSetting($key);
		if(!$setting) {
			return 0;
		}
		return strtotime($setting);
	}
	
	/**
	 * action show
	 *
	 * @param \VJmedia\Vjeventdb3\Domain\Model\Event $event
	 * @return void
	 */
	public function showAction(\VJmedia\Vjeventdb3\Domain\Model\Event $event) {

		$this->view->assign('event', $event);
		
		if($this->anyDateShouldBeShown()) {
		
			$maxItemsPerDate = max(
					$this->getSetting('show.allDates.maxItems', 10),
					$this->getSetting('show.nextDates.maxItems', 10),
					$this->getSetting('show.nextDate.maxItems', 10)
			);
			
			$minStartTimestamp = min(
					$this->getTimestampFromSetting('show.allDates.startTime'),
					$this->getTimestampFromSetting('show.nextDates.startTime'),
					$this->getTimestampFromSetting('show.nextDate.startTime')
			);
	
			$maxEndTimestamp = max(
					$this->getTimestampFromSetting('show.allDates.endTime'),
					$this->getTimestampFromSetting('show.nextDates.endTime'),
					$this->getTimestampFromSetting('show.nextDate.endTime')
			);
			
			$dates = $this->getDatesOfEvent(
					$event, 
					$this->getDateTimeFromTimestamp($minStartTimestamp), 
					$this->getDateTimeFromTimestamp($maxEndTimestamp), 
					$maxItemsPerDate
			);
			
			
			$allDates = $this->getDateService()->getDatesWithinRange($dates,
					$this->getTimestampFromSetting('show.allDates.startTime'),
					$this->getTimestampFromSetting('show.allDates.endTime'),
					$this->getSetting('show.allDates.maxItems', 10)
			);
	
			$nextDates = $this->getDateService()->getDatesWithinRange($dates,
					$this->getTimestampFromSetting('show.nextDates.startTime'),
					$this->getTimestampFromSetting('show.nextDates.endTime'),
					$this->getSetting('show.nextDates.maxItems', 10)
			);
			
			$nextDate = $this->getDateService()->getDatesWithinRange($dates,
					$this->getTimestampFromSetting('show.nextDate.startTime'),
					$this->getTimestampFromSetting('show.nextDate.endTime'),
					$this->getSetting('show.nextDate.maxItems', 10)
			);		
			
			$this->view->assign('alldates', $this->getSetting('show.allDates.show') ? $allDates : '');
			$this->view->assign('nextdates', $this->getSetting('show.nextDates.show') ? $nextDates : '');
			$this->view->assign('nextdate', $this->getSetting('show.nextDate.show') ? $nextDate : '');
			
		}
		
		$this->view->assign('prices', $prices);
		$this->view->assign('priceCategories', $this->getPriceCategories($event->getPrices()));
		$this->view->assign('showAnyDate', $this->anyDateShouldBeShown());
		
	}
	
	private function anyDateShouldBeShown() {
		return $this->getSetting('show.dates.show') || $this->getSetting('show.allDates.show') || $this->getSetting('show.nextDates.show') || $this->getSetting('show.nextDate.show');
	}
	
	private function getSetting($key, $defaultValue = '') {
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
	

	private function setTemplatePaths($config) {
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
	
	/**
	 * action gallery
	 *
	 * @return void
	 */
	public function galleryAction() {

		$this->setTemplatePaths($this->settings['gallery']);
		
		$events = $this->eventRepository->findAllByCategory(
				$this->getEventCategoryFilter(),
				$this->getAgeCategoryFilter()
		);
		
		$this->view->assign('events', $events);
		
	}

}