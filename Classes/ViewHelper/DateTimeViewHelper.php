<?php 

namespace VJmedia\Vjeventdb3\ViewHelper;
 
use \DateTime;

/**
 *
 * Example
 * {namespace m=VJmedia\Vjeventdb3\ViewHelper}
 * <m:dateTime date="\DateTime" key="day.long" />
 *
 */
class DateTimeViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {
     
     /**
     * Renders a part of a date using the given language key suffix.
     *
     * @param \DateTime The date.
     * @param string The key.
     * @return The localized date part.
     */
    public function render(\DateTime $date, $key) {
    	$llKey = '';
    	if($key == "day.long") {
    		$index = $date->format('w');
    		$llKey = 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang.xlf:tx_vjeventdb3_day.long.' . $index;
    	}
    	if($key == "day.short") {
    		$index = $date->format('w');
    		$llKey = 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang.xlf:tx_vjeventdb3_day.short.' . $index;
    	}
    	
   		if($result = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($llKey, '')) {
   			return $result;
   		}
		return $llKey." not found.";
    }
}
?>