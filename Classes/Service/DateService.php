<?php
namespace VJmedia\Vjeventdb3\Service;

use VJmedia\Vjeventdb3\Domain\ViewModel\EventsView;
use VJmedia\Vjeventdb3\Domain\ViewModel\SectionsView;
use VJmedia\Vjeventdb3\Domain\Model\Date;
use VJmedia\Vjeventdb3\Service\DateUtils;
use DateTime;
use DateInterval;

/**
 * 
 * Calculates all dates from a set of dates with a certain frequency (e.g. daily) between a given time period.
 * 
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *         
 * @author Vincent Tietz <vincent.tietz@vj-media.de>
 *
 */
class DateService {

	const LEVEL_DAY = 0;
	const LEVEL_WEEK = 1;
	const LEVEL_MONTH = 2;
	const LEVEL_YEAR = 3;

	public function __construct() {
	}
	
	/**
	 * Calculates all dates from a set of dates with a certain frequency (e.g. Daily) between a goven time period.
	 * 
	 * @param array $dates The source of dates.
	 * @param \DateTime $rangeStartDateTime The start date for valid dates.
	 * @param \DateTime $rangeEndDateTime The end date for valid dates.
	 */
	public function getAllDates($dates, \DateTime $rangeStartDateTime, \DateTime $rangeEndDateTime, $maxItemsPerDate = 50) {

		
		$theDates = array();
		foreach($dates as $date) {
			/* @var $date \VJmedia\Vjeventdb3\Domain\Model\Date */

			$startDateTime = $rangeStartDateTime->getTimestamp() !== FALSE ? $rangeStartDateTime : $date->getStartDate();
			$endDateTime = $rangeEndDateTime->getTimestamp() !== FALSE ? $rangeEndDateTime : $date->getEndDate();
			
			if(($date->getFrequency() == Date::FREQUENCY_ONCE) && ($this->isValid($date, $startDateTime, $endDateTime)) &&
						(DateService::getStartTimestamp($date) >= $startDateTime->getTimestamp())) {
					$this->addDate($theDates, $date);
					continue;
			}
			
			if($date->getFrequency() == Date::FREQUENCY_DAILY) {
				$startOffset = DateUtils::datediff(DateUtils::DIFF_MODE_DAYS, $date->getStartDate(), $startDateTime);
				$this->makeNewDates($theDates, $maxItemsPerDate, $date, "day", $startOffset, $startDateTime, $endDateTime);
			}
			elseif($date->getFrequency() == Date::FREQUENCY_WEEKLY) {
				$startOffset = DateUtils::datediff(DateUtils::DIFF_MODE_WEEKS, $date->getStartDate(), $startDateTime);
				$this->makeNewDates($theDates, $maxItemsPerDate, $date, "week", $startOffset, $startDateTime, $endDateTime);
			}				
			elseif($date->getFrequency() == Date::FREQUENCY_MONTHLY) {
				$startOffset = DateUtils::datediff(DateUtils::DIFF_MODE_MONTHS, $date->getStartDate(), $startDateTime);
				$this->makeNewDates($theDates, $maxItemsPerDate, $date, "month", $startOffset, $startDateTime, $endDateTime);
			}				
			elseif($date->getFrequency() == Date::FREQUENCY_YEARLY) {
				$startOffset = DateUtils::datediff(DateUtils::DIFF_MODE_YEARS, $date->getStartDate(), $startDateTime);
				$this->makeNewDates($theDates, $maxItemsPerDate, $date, "year", $startOffset, $startDateTime, $endDateTime);
			}				
		} 
		
		$this->removeKeysFromArray($theDates);
		$this->sortDates($theDates);
		
		return $theDates;
		
	}
	
	
	public function sortDates(&$dates) {
		usort($dates, array('VJmedia\Vjeventdb3\Service\DateService', 'compare'));
	}

	/**
	 * Removes all dates above the given limit (amount of events).
	 * @param array $dates The dates.
	 * @param string $limit The limit.
	 * @return array
	 */
	public function limitDates(&$dates, $limit = NULL) {
		if($limit == NULL || !$limit) {
			return $dates;
		}
		return array_slice($dates, 0, $limit);
	}
	
	
	private function removeKeysFromArray($array) {
		$theArray = array();
		foreach ($array as $item) {
			$theArray[] = &$item;
		}
		return $theArray;
	}
	
	/**
	 * @param \VJmedia\Vjeventdb3\Domain\Model\Date $date The date.
	 * @param string $intervalString The relative time which is added to each new date.
	 */
	private function makeNewDates(&$dates, $maxItemsPerDate, $date, $intervalString, $startOffset, $startDateTime, $endDateTime) {
		$date = unserialize(serialize($date)); // make deep copy of the object
		// make the first date
		if($startOffset > 0) {
			$date->getStartDate()->add(DateInterval::createfromdatestring("+".$startOffset." ".$intervalString));
		}
		// add first date if valid and add all further dates till the $endDateTime is reached
		while($this->isValid($date, $startDateTime, $endDateTime) && (count($dates) < $maxItemsPerDate)) {
			if(DateService::getStartTimestamp($date) >= $startDateTime->getTimestamp()) {
				$this->addDate($dates, unserialize(serialize($date))); // make deep copy of the object
			}
			$date->getStartDate()->add(DateInterval::createfromdatestring("+1 ".$intervalString));
		}
		return $dates;
	}

	/**
	 * Checks if the start and end dates of a given date are valid.
	 * @param \VJmedia\Vjeventdb3\Domain\Model\Date $date The date object.
	 * @param \DateTime $startDateTime The start date of the range.
	 * @param \DateTime $endDateTime The end date of the range.
	 * @return boolean True if the date has valid dates regarding the given range. Otherwise false. 
	 */
	private static function isValid($date, $startDateTime, $endDateTime) {
		
		// not valid if start date is before the start date of the given date range
		/*
		if(DateService::getStartTimestamp($date) < $startDateTime->getTimestamp()) {
			return false;
		}
		*/
		
		// not valid if start date is after end date of the given range
		if($endDateTime && ($date->getStartDate()->getTimestamp() > $endDateTime->getTimestamp())) {
			return false;
		}
		
		
		if($date->getEndDate() && ($date->getEndDate()->getTimestamp() !== FALSE)) {
		
			// not valid if start date is after end date of the date
			if($date->getStartDate()->getTimestamp() > $date->getEndDate()->getTimestamp()) {
				return false;
			}
			
			// not valid if an end date is given and the end date is before the start date of the given range  
			if($startDateTime && ($date->getEndDate()->getTimestamp() < $startDateTime->getTimestamp())) {
				return false;
			}
			
		}
		
		return true;
		
	}
	
	/**
	 * Adds a date to the given array if the sorting is bigger than the existing item.
	 * @param array $dates The dates in the form $dates[$timestamp]
	 * @param \VJmedia\Vjeventdb3\Domain\Model\Date $date
	 * @return array
	 */
	private function addDate(&$dates, $date) {
		$timestamp = $this->getStartTimestamp($date);
		$existingDate = $dates[$timestamp]; 
		if($existingDate && $existingDate->getSorting() > $date->getSorting()) {
			return $dates;
		}
		$dates[$timestamp] = $date;
		return $dates;
	}
	
	/**
	 * Returns the timestamp consisting of start date and start time.
	 * @param \VJmedia\Vjeventdb3\Domain\Model\Date $date
	 * @return integer The start timestamp.
	 */
	private function getStartTimestamp($date) {
		return $date->getStartDate()->getTimestamp() + $date->getStartTime();
	}
	
	/**
	 * Compare callback function for sorting date arrays.
	 * @param \VJmedia\Vjeventdb3\Domain\Model\Date $a
	 * @param \VJmedia\Vjeventdb3\Domain\Model\Date $b
	 * @return number
	 */
	static function compare(\VJmedia\Vjeventdb3\Domain\Model\Date $a, \VJmedia\Vjeventdb3\Domain\Model\Date $b) {
		
		$startDateTimeA = $a->getStartDate()->getTimestamp() + $a->getStartTime();
		$startDateTimeB = $b->getStartDate()->getTimestamp() + $b->getStartTime();
 		
		return $startDateTimeA - $startDateTimeB;  
		
	}
	
	public function getDuration($date) {
		if($date->getEndTime() - $date->getStartTime() > 0) {
			$startTimeStamp = $date->getStartTime();
			$endTimeStamp = $date->getEndTime();
			return DateUtils::formatDateDiff(new DateTime(date("c", $startTimeStamp)), new DateTime(date("c", $endTimeStamp)));
		}
		return '';
	}
	
	/**
	 * @param array $dates
	 * @return array The next dates from now.
	 */
	public function getNextDates($dates, $maxItems = 0) {
		$nextDates = array();
		foreach($dates as $date) {
			if($this->getStartTimestamp($date) >= time()) {
				$nextDates[] = $date;
			}
			if(count($nextDates) > $maxItems) {
				break;
			}
		}
		return $nextDates;
	}	
	
	public function getDatesWithinRange($dates, $starttime, $endtime, $maxItems) {
		$theDates = array();
		foreach ($dates as $date) {
			$timestamp = $this->getStartTimestamp($date);
			if($this->isInRange($timestamp, $starttime, $endtime)) {
				$theDates[] = $date;				
			}
			if(count($theDates) >= $maxItems) {
				break;
			}
		}
		return $theDates;
	}
	
	public function isInRange($timestamp, $starttime, $endtime) {
		if(($timestamp >= $starttime) && (($timestamp <= $endtime) || !$endtime)) {
			return true;
		}
		return false;
	}
	
}