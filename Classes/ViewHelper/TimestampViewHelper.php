<?php

namespace VJmedia\Vjeventdb3\ViewHelper;

use \DateTime;

/**
 * Example
 * {namespace m=VJmedia\Vjeventdb3\ViewHelper}
 * <m:timestamp time="int" format="string" />
 */
class TimestampViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {
	/**
	 * Renders a part of a date using the given language key suffix.
	 *
	 * @param integer The time.
	 * @param string The format.
	 * @param string The adjustment.
	 * 
	 * @return The formatted time.
	 */
	public function render($time, $format, $adjust = '') {
			
		if($adjust) {
			$time = strtotime($adjust, $time);
		}
		return date($format, $time);
		
	}
}
?>