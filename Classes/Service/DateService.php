<?php
namespace VJmedia\Vjeventdb3\Service;

/**
 * 
 * Provides some methods to convert and to calculate dates.
 * 
 * @author Vincent Tietz
 *
 */
class DateService implements \TYPO3\CMS\Core\SingletonInterface {
	
	const DIFF_MODE_YEARS = "yyyy";
	const DIFF_MODE_MONTHS = "m";
	const DIFF_MODE_WEEKS = "w";
	const DIFF_MODE_DAYS = "d";
	
	public function getDaySections($startdate, $enddate) {
		$dayCount = $this->datediff(DateService::DIFF_MODE_DAYS, $startdate, $enddate, false);
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
	public function geDaysCount($startdate, $enddate) {
		return $this->datediff(DateService::DIFF_MODE_DAYS, $startdate, $enddate, false);
	} 
	
	/**
	 * @param unknown $interval
	 * @param unknown $datefrom
	 * @param unknown $dateto
	 * @param string $using_timestamps
	 * @return number
	 * @see http://www.addedbytes.com/blog/code/php-datediff-function/
	 */
	private function datediff($interval, $datefrom, $dateto, $using_timestamps = false) {
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
		
		var_dump($interval);
	
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