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
	 * @param \DateTime $startDateTime The start date for valid dates.
	 * @param \DateTime $endDateTime The end date for valid dates.
	 */
	public function getAllDates($dates, $startDateTime, $endDateTime) {

		$theDates = array();
		foreach($dates as $date) {
			/* @var $date \VJmedia\Vjeventdb3\Domain\Model\Date */

			if(!$this->isValid($date, $startDateTime, $endDateTime)) {
				continue;
			}
			elseif($date->getFrequency() == Date::FREQUENCY_ONCE) {
				$this->addDate($theDates, $date);
			}
			elseif($date->getFrequency() == Date::FREQUENCY_DAILY) {
				$this->makeNewDates($theDates, $date, "+1 day", $startDateTime, $endDateTime);
			}
			elseif($date->getFrequency() == Date::FREQUENCY_WEEKLY) {
				$this->makeNewDates($theDates, $date, "+1 week", $startDateTime, $endDateTime);
			}				
			elseif($date->getFrequency() == Date::FREQUENCY_MONTHLY) {
				$this->makeNewDates($theDates, $date, "+1 month", $startDateTime, $endDateTime);
			}				
			elseif($date->getFrequency() == Date::FREQUENCY_YEARLY) {
				$this->makeNewDates($theDates, $date, "+1 year", $startDateTime, $endDateTime);
			}				
		} 
		
		$this->removeKeysFromArray($theDates);
		$this->sortDates($theDates);
		
		
		return $theDates;
		
	}
	
	
	public function sortDates(&$dates) {
		usort($dates, array('VJmedia\Vjeventdb3\Service\DateService', 'compare'));
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
	private function makeNewDates(&$dates, $date, $intervalString, $startDateTime, $endDateTime) {
		while($this->isValid($date, $startDateTime, $endDateTime)) {
			$this->addDate($dates, unserialize(serialize($date))); // make deep copy of the object
			$date->getStartDate()->add(DateInterval::createfromdatestring($intervalString));
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
		
		// not valid of start date is after end date of the given range
		if($date->getStartDate()->getTimestamp() > $endDateTime->getTimestamp()) {
			return false;
		}
		
		
		if($date->getEndDate() && ($date->getEndDate()->getTimestamp() !== FALSE)) {
		
			// not valid if start date is after end date of the date
			if($date->getStartDate()->getTimestamp() > $date->getEndDate()->getTimestamp()) {
				return false;
			}
			
			// not valid if an end date is given and the end date is before the start date of the given range  
			if($date->getEndDate()->getTimestamp() < $startDateTime->getTimestamp()) {
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
	 * @param unknown $dates
	 * @return \VJmedia\Vjeventdb3\Domain\Model\Date|NULL The next date from now.
	 */
	public function getNextDate($dates) {
		foreach($dates as $date) {
			if($this->getStartTimestamp($date) >= time()) {
				return $date;
			}
		}
		return NULL;
	}
	
	/**
	 * @param unknown $dates
	 * @return array The next dates from now.
	 */
	public function getNextDates($dates) {
		$nextDates = array();
		foreach($dates as $date) {
			if($this->getStartTimestamp($date) >= time()) {
				$nextDates[] = $date;
			}
		}
		return $nextDates;
	}	
	
}