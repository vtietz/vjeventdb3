<?php
namespace VJmedia\Vjeventdb3\Controller;

use VJmedia\Vjeventdb3\Domain\Repository\PerformerRepository;
use \DateTime;

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
abstract class AbstractEventListController extends \VJmedia\Vjeventdb3\Controller\AbstractController {

	/**
	 * eventRepository
	 *
	 * @var \VJmedia\Vjeventdb3\Domain\Repository\EventRepository
	 * @inject
	 */
	protected $eventRepository = NULL;
	
	/**
	 * dateService
	 *
	 * @var \VJmedia\Vjeventdb3\Service\DateService
	 */
	protected $dateService = NULL;
	
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
	
	protected function makeYearSections($allEventDates) {
	
		$years = array();
		$year = null;
		$month = null;
		$day = null;

		$yearCount = 0;
		$monthCount = 0;
		$dayCount = 0;
		$dateCount = 0;
		
		foreach ($allEventDates as $date) {
			
			if($this->isNewSectionRequired($year, $date, 'Y')) {
				if($this->isOverLimit($yearCount, $this->settings['maxYearSections'])) {
					break;
				}
				$year = new \VJmedia\Vjeventdb3\Domain\ViewModel\YearSectionView();
				$year->setDate($date->getStartDate());
				$years[] = $year;
				$month = null;
				$yearCount++;
			}
			
			if($this->isNewSectionRequired($month, $date, 'm')) {
				if($this->isOverLimit($monthCount, $this->settings['maxMonthSections'])) {
					break;
				}
				$month = new \VJmedia\Vjeventdb3\Domain\ViewModel\MonthSectionView();
				$month->setDate($date->getStartDate());
				$year->addMonth($month);
				$day = null;
				$monthCount++;
			}
				
			if($this->isNewSectionRequired($day, $date, 'd')) {
				if($this->isOverLimit($dayCount, $this->settings['maxDaySections'])) {
					break;
				}
				$day = new \VJmedia\Vjeventdb3\Domain\ViewModel\DaySectionView();
				$day->setDate($date->getStartDate());
				$month->addDay($day);
				$dayCount++;
			}
					
			if($this->isOverLimit($dateCount, $this->settings['maxItems'])) {
				break;
			}
			$day->addDate($date);
			$dateCount++;
		}
	
		return $years;
	
	}
	
	private function isNewSectionRequired($oldDate, $currentDate, $dateFormat) {
		if($oldDate == null) {
			return true;
		}
		if($newDate == null) {
			return false;
		}
		return $oldDate->getDate()->format($dateFormat) != $newDate->getStartDate()->format($dateFormat);
	}
	
	private function isOverLimit($itemCount, $value) {
		if(isset($value) && $value) {
			return $itemCount >= $value;
		}
		else {
			return false;
		}
	}


	protected function getStartTimeFromArguments($rangeSettings) {
	
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
	
	protected function getEventCategoryFilter() {
		$list = $this->getArgument('eventCategories', $this->settings['eventCategoryFilter']);
		if(!$list) {
			return array();
		}
		return \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $list);
	}
	
	protected function getAgeCategoryFilter() {
		$list = $this->getArgument('ageCategories', $this->settings['ageCategoryFilter']);
		if(!$list) {
			return array();
		}
		return \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $list);
	}	

	
	protected function getAllDateEvents($startDateTime, $endDateTime, $limit = NULL) {
	
		$events = $this->eventRepository->findAllInDateRange(
				$startDateTime,
				$endDateTime,
				$limit,
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
	
	protected function getDatesOfEvent(\VJmedia\Vjeventdb3\Domain\Model\Event $event, \DateTime $startDateTime, \DateTime $endDateTime, $maxItemsPerDate = 50) {
	
		$eventDates = $this->getDateService()->getAllDates($event->getDates(), $startDateTime, $endDateTime, $maxItemsPerDate);
		foreach($eventDates as $date) {
			$date->setEvent($event);
			$date->setDuration($this->getDateService()->getDuration($date));
		}
		return $eventDates;
	}


	protected function getDateService() {
		if($this->dateService == NULL)  {
			$this->dateService = new \VJmedia\Vjeventdb3\Service\DateService();
		}
		return $this->dateService;
	}
	
	protected function getDateTimeFromTimestamp($timestamp) {
		if($timestamp == 0) {
			return new DateTime("0000-00-00");
		}
		$dateString = date('Y-m-d', $timestamp);
		return new DateTime($dateString);
	}
	
	protected function getTimestampFromSetting($key) {
		$setting = $this->getSetting($key);
		if(!$setting) {
			return 0;
		}
		return strtotime($setting);
	}
	
	
}