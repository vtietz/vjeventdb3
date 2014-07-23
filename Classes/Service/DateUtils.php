<?php
namespace VJmedia\Vjeventdb3\Service;

use VJmedia\Vjeventdb3\Domain\Model\Date;
use \DateTime;

/**
 * 
 * Provides some methods to convert and to calculate dates.
 * 
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *         
 * @author Vincent Tietz <vincent.tietz@vj-media.de>
 *
 */
class DateUtils {
	
	const DIFF_MODE_YEARS = "yyyy";
	const DIFF_MODE_MONTHS = "m";
	const DIFF_MODE_WEEKS = "ww";
	const DIFF_MODE_DAYS = "d";
	
	private function __construct() {
	}
	
	public static function getDaySections($startdate, $enddate) {
		$dayCount = static::datediff(DateService::DIFF_MODE_DAYS, $startdate, $enddate, false);
		$theValue = array();
		for ($i = 0; $i < $dayCount; $i++) {
			$theValue[$i] = strtotime(" +".((string)$i). " day",  strtotime($startdate, 0));
		}
		return $theValue;
	}
	
	/**
	 * @param number $startdate The start timestamp.
	 * @param number $enddate The end timestamp.
	 * @return number Amount of days.
	 */
	public static function geDaysCount($startdate, $enddate) {
		return static::datediff(DateService::DIFF_MODE_DAYS, $startdate, $enddate, false);
	} 

	/**
	 * @param number $startdate The start timestamp.
	 * @param number $enddate The end timestamp.
	 * @return number Amount of weeks.
	 */
	public static function getWeeksCount($startdate, $enddate) {
		return static::datediff(DateService::DIFF_MODE_WEEKS, $startdate, $enddate, false);
	}

	/**
	 * @param number $startdate The start timestamp.
	 * @param number $enddate The end timestamp.
	 * @return number Amount of months.
	 */
	public static function getMonthsCount($startdate, $enddate) {
		return static::datediff(DateService::DIFF_MODE_MONTHS, $startdate, $enddate, false);
	}
	
	/**
	 * @param number $startdate The start timestamp.
	 * @param number $enddate The end timestamp.
	 * @return number Amount of years.
	 */
	public static function getYearsCount($startdate, $enddate) {
		return static::datediff(DateService::DIFF_MODE_YEARS, $startdate, $enddate, false);
	}
	

	/**
	 * A sweet interval formatting, will use the two biggest interval parts.
	 * On small intervals, you get minutes and seconds.
	 * On big intervals, you get months and days.
	 * Only the two biggest parts are used.
	 *
	 * @param DateTime $start
	 * @param DateTime|null $end
	 * @return string
	 * @see http://php.net/manual/de/dateinterval.format.php
	 */
	public static function formatDateDiff($start, $end=null) {
		if(!($start instanceof DateTime)) {
			$start = new DateTime($start);
		}
		 
		if($end === null) {
			$end = new DateTime();
		}
		 
		if(!($end instanceof DateTime)) {
			$end = new DateTime($start);
		}
		 
		$interval = $end->diff($start);
		$doPlural = function($nb,$str){return $nb>1?$str.'s':$str;}; // adds plurals
		 
		$format = array();
		if($interval->y !== 0) {
			$format[] = "%y ".$doPlural($interval->y, "year");
		}
		if($interval->m !== 0) {
			$format[] = "%m ".$doPlural($interval->m, "month");
		}
		if($interval->d !== 0) {
			$format[] = "%d ".$doPlural($interval->d, "day");
		}
		if($interval->h !== 0) {
			$format[] = "%h ".$doPlural($interval->h, "hour");
		}
		if($interval->i !== 0) {
			$format[] = "%i ".$doPlural($interval->i, "minute");
		}
		if($interval->s !== 0) {
			if(!count($format)) {
				return "less than a minute ago";
			} else {
				$format[] = "%s ".$doPlural($interval->s, "second");
			}
		}
		 
		// We use the two biggest parts
		if(count($format) > 1) {
			$format = array_shift($format)." and ".array_shift($format);
		} else {
			$format = array_pop($format);
		}
		 
		// Prepend 'since ' or whatever you like
		return $interval->format($format);
	}	
	
	/**
	 * @param unknown $interval
	 * @param unknown $datefrom
	 * @param unknown $dateto
	 * @param string $using_timestamps
	 * @return number
	 * @see http://www.addedbytes.com/blog/code/php-datediff-function/
	 */
	public static function datediff($interval, $datefrom, $dateto, $using_timestamps = false) {
		/*
		 $interval can be:
		yyyy - Number of full years
		q - Number of full quarters
		m - Number of full months
		y - Difference between day numbers
		(eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)
		d - Number of full days
		w - Number of full weekdays
		ww - Number of full weeks
		h - Number of full hours
		n - Number of full minutes
		s - Number of full seconds (default)
		*/
		
		if($datefrom instanceof DateTime && $dateto instanceof DateTime) {
			$datefrom = $datefrom->getTimestamp();
			$dateto = $dateto->getTimestamp();
			$using_timestamps = true;
		}
		
		if (!$using_timestamps) {
			$datefrom = strtotime($datefrom, 0);
			$dateto = strtotime($dateto, 0);
		}
		$difference = $dateto - $datefrom; // Difference in seconds
		 
		switch($interval) {
			 
			case 'yyyy': // Number of full years
				$years_difference = floor($difference / 31536000);
				if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom)+$years_difference) > $dateto) {
					$years_difference--;
				}
				if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto)-($years_difference+1)) > $datefrom) {
					$years_difference++;
				}
				$datediff = $years_difference;
				break;
			case "q": // Number of full quarters
				$quarters_difference = floor($difference / 8035200);
				while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($quarters_difference*3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
					$months_difference++;
				}
				$quarters_difference--;
				$datediff = $quarters_difference;
				break;
			case "m": // Number of full months
				$months_difference = floor($difference / 2678400);
				while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
					$months_difference++;
				}
				$months_difference--;
				$datediff = $months_difference;
				break;
			case 'y': // Difference between day numbers
				$datediff = date("z", $dateto) - date("z", $datefrom);
				break;
			case "d": // Number of full days
				$datediff = floor($difference / 86400);
				break;
			case "w": // Number of full weekdays
				$days_difference = floor($difference / 86400);
				$weeks_difference = floor($days_difference / 7); // Complete weeks
				$first_day = date("w", $datefrom);
				$days_remainder = floor($days_difference % 7);
				$odd_days = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?
				if ($odd_days > 7) { // Sunday
					$days_remainder--;
				}
				if ($odd_days > 6) { // Saturday
					$days_remainder--;
				}
				$datediff = ($weeks_difference * 5) + $days_remainder;
				break;
			case "ww": // Number of full weeks
				$datediff = floor($difference / 604800);
				break;
			case "h": // Number of full hours
				$datediff = floor($difference / 3600);
				break;
			case "n": // Number of full minutes
				$datediff = floor($difference / 60);
				break;
			default: // Number of full seconds (default)
				$datediff = $difference;
				break;
		}
		return $datediff;
	}
	
	
}