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
	 * Calculates all dates from a set of dates with a certain frequency (e.g. Daily) between a given time period.
	 * 
	 * @param array $dates The source of dates.
	 * @param \DateTime $startDateTime The start date for valid dates.
	 * @param \DateTime $endDateTime The end date for valid dates.
	 */
	public function getAllDates($dates, $startDateTime, $endDateTime, $maxItemsPerDate = 50) {
		
		$theDates = array();
		/* @var $date \VJmedia\Vjeventdb3\Domain\Model\Date */
		foreach($dates as $date) {
			if($date->isHidden()) {
				continue;
			}
			$appointments = $this->getDates($date, $startDateTime, $endDateTime, $maxItemsPerDate);
			foreach($appointments as $appointment) {
				$this->addDate($theDates, $appointment);
			}
		} 
		
		$this->sortDates($theDates);
		
		return $theDates;
		
	}
	
	/**
	 * @param \VJmedia\Vjeventdb3\Domain\Model\Date $date The date object.
	 * @param \DateTime $startDateTime
	 * @param \DateTime $endDateTime
	 * @param number $maxItems
	 * @return multitype:|multitype:\VJmedia\Vjeventdb3\Domain\Model\Date
	 */
	public function getDates($date, $startDateTime, $endDateTime, $maxItems = 50) {
		
		if(!is_object($date)) {
			return array();
		}
		
		if(!$date->getStartDate()) {
			$this->log('Skipping date '.$date->getUid().' since no start date given. This is strange because start date is a required field.',2);
			return array();
		}

		if(!$this->isValid($date, $startDateTime, $endDateTime)) { 
			return array();
		}
			
		$theDates = array();
		if($date->getFrequency() == Date::FREQUENCY_ONCE) {
			$this->addDate($theDates, $date);
		}
			
		if($date->getFrequency() == Date::FREQUENCY_DAILY) {
			$startOffset = DateUtils::datediff(DateUtils::DIFF_MODE_DAYS, $date->getStartDate(), $startDateTime);
			$this->makeNewDates($theDates, $maxItems, $date, "day", $startOffset, $startDateTime, $endDateTime);
		}
		elseif($date->getFrequency() == Date::FREQUENCY_WEEKLY) {
			$startOffset = DateUtils::datediff(DateUtils::DIFF_MODE_WEEKS, $date->getStartDate(), $startDateTime);
			$this->makeNewDates($theDates, $maxItems, $date, "week", $startOffset, $startDateTime, $endDateTime);
		}
		elseif($date->getFrequency() == Date::FREQUENCY_MONTHLY) {
			$startOffset = DateUtils::datediff(DateUtils::DIFF_MODE_MONTHS, $date->getStartDate(), $startDateTime);
			$this->makeNewDates($theDates, $maxItems, $date, "month", $startOffset, $startDateTime, $endDateTime);
		}
		elseif($date->getFrequency() == Date::FREQUENCY_YEARLY) {
			$startOffset = DateUtils::datediff(DateUtils::DIFF_MODE_YEARS, $date->getStartDate(), $startDateTime);
			$this->makeNewDates($theDates, $maxItems, $date, "year", $startOffset, $startDateTime, $endDateTime);
		}

		return $theDates;
		
	}
	
	public function sortDates(&$dates) {
		$this->removeKeysFromArray($dates);
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
	
	/**
	 * Adds all dates which match exactly one exceptional date.
	 * @param unknown $allEventDates The dates.
	 * @param unknown $exceptionalDates The exceptional dates.
	 */
	public function addExceptionalDates($allEventDates, $exceptionalDates) {
		foreach ($allEventDates as $date) {
			$this->addExceptionalDate($date, $exceptionalDates);
		}
		return $allEventDates;
	}
	
	/**
	 * Adds an exceptional date to the date if it exists.
	 * @param unknown $date
	 * @param unknown $exceptionalDates
	 */
	public function addExceptionalDate($date, $exceptionalDates) {
		
		foreach ($exceptionalDates as $exceptionalDate) {

			$exceptionalDateTimestamp = DateUtils::getTimestampFromDayInDateTime($exceptionalDate->getStartDate()) +
				$exceptionalDate->getStartTime();
			
			if($date->getStartTimestamp() == $exceptionalDateTimestamp) {
				$date->setExceptionalDate($exceptionalDate);
				// only one exception is possible per date
				return;
			}
		}
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
	private function makeNewDates(&$dates, $maxItemsPerDate, $date, $intervalString, $startOffset, $startDateTime, $endDateTime = NULL) {
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
	private static function isValid(\VJmedia\Vjeventdb3\Domain\Model\Date $date, \DateTime $startDateTime, \DateTime $endDateTime = NULL) {
		
		// not valid if start date is after end date of the given range
		if($endDateTime) {
			if($endDateTime && ($date->getStartDate()->getTimestamp() > $endDateTime->getTimestamp())) {
				return false;
			}
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
		$date->setStartTimestamp($timestamp);
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
		return DateUtils::getTimestampFromDayInDateTime($date->getStartDate()) + $date->getStartTime();
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

	/**
	 * Wrapper for dev log, in order to ease testing
	 *
	 * @param string $message Message (in english).
	 * @param integer $severity Severity: 0 is info, 1 is notice, 2 is warning, 3 is fatal error, -1 is "OK" message
	 * @return void
	 */
	protected function log($message, $severity) {
		\TYPO3\CMS\Core\Utility\GeneralUtility::devLog($message, 'vjeventdb3', $severity);
	}
	
	
}