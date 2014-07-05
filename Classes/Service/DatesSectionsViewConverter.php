<?php
namespace VJmedia\Vjeventdb3\Service;

use VJmedia\Vjeventdb3\Domain\ViewModel\EventsView;
use VJmedia\Vjeventdb3\Domain\ViewModel\SectionsView;
use VJmedia\Vjeventdb3\Domain\Model\Date;
use DateTime;
use DateInterval;

class DatesSectionsViewConverter {

	const LEVEL_DAY = 0;
	const LEVEL_WEEK = 1;
	const LEVEL_MONTH = 2;
	const LEVEL_YEAR = 3;

	/**
	 * @var \VJmedia\Vjeventdb3\Service\DateService
	 */
	protected $dateService = NULL;
	
	function __construct() {
		$this->dateService = new DateService();
	}
	
	/**
	 * @param array $dates
	 */
	public function getSectionsView($dates, $starttime, $endtime, $startlevel, $endlevel) {
		
		$sectionsViews = array();

		//if (TYPO3_DLOG)	\TYPO3\CMS\Core\Utility\GeneralUtility::devLog('[write message in english here]', 'extension key');
		
		if($startlevel == $this::LEVEL_YEAR) {
			$yearCount = $this->dateService->getYearsCount($starttime, $endtime);
			for($i = 0; $i<yearCount ;$i++) {
				$sectionView = new SectionsView();
				$sectionView->setSectionTitle(strtotime('Y + ' + $i + ' year', $starttime));
				$sectionsViews[] = $sectionsView;
			}
		}
		
		$eventsView = new EventsView();
		
		
	}
	
	/**
	 * @param array $dates
	 * @param \DateTime $startDateTime
	 * @param \DateTime $endDateTime
	 */
	public function getAllDates($dates, $startDateTime, $endDateTime) {

		$theDates = array();
		foreach($dates as $date) {
			/* @var $date \VJmedia\Vjeventdb3\Domain\Model\Date */

			if(!$this->isValid($date, $startDateTime, $endDateTime)) {
				continue;
			}
			
			if($date->getFrequency() == Date::FREQUENCY_ONCE) {
				$theDates[] = $date;
			}
			if($date->getFrequency() == Date::FREQUENCY_DAILY) {
				$this->makeNewDates($theDates, $date, "+1 day", $startDateTime, $endDateTime);
			}
			if($date->getFrequency() == Date::FREQUENCY_WEEKLY) {
				$this->makeNewDates($theDates, $date, "+1 week", $startDateTime, $endDateTime);
			}				
			if($date->getFrequency() == Date::FREQUENCY_MONTHLY) {
				$this->makeNewDates($theDates, $date, "+1 month", $startDateTime, $endDateTime);
			}				
			if($date->getFrequency() == Date::FREQUENCY_YEARLY) {
				$this->makeNewDates($theDates, $date, "+1 year", $startDateTime, $endDateTime);
			}				
		} 
		
		return $theDates;
		
	}
	
	/**
	 * @param \VJmedia\Vjeventdb3\Domain\Model\Date $date The date.
	 * @param string $intervalString The relative time which is added to each new date.
	 */
	private function makeNewDates(&$dates, $date, $intervalString, $startDateTime, $endDateTime) {
		$dates[] = $date;
		$newDate = $date;
		while($this->isValid($newDate, $startDateTime, $endDateTime)) {
			$newDate = clone $date;
			$newDate->getStartDate()->add(DateInterval::createfromdatestring($intervalString));
			if($newDate->getStartDate()->getTimestamp() <= $date->getEndDate()->getTimestamp()) {
				$dates[] = $newDate;
			}
			else {
				return $dates;
			}
		}
		return $dates;
	}

	private function isValid($date, $startDateTime, $endDateTime) {
		
		if($date->getStartDate()->getTimestamp() > $endDateTime->getTimestamp()) {
			return false;
		}

		/*
		if(($date->getEndDate()->format('Y-m-d') != '0000-00-00') && 
			($date->getEndDate()->getTimestamp() < $startDateTime->getTimestamp())) {
			return false;
		}
		*/
		
		return true;
		
	}
	
}