<?php 

namespace VJmedia\Vjeventdb3\ViewHelper;
 
/**
 *
 * Example
 * {namespace m=VJmedia\Vjeventdb3\ViewHelper}
 * <m:durationTranslate duration="1 hour" />
 *
 */
class DurationTranslateViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {
     
     /**
     * Renders a part of a date using the given language key suffix.
     *
     * @param string The duration.
     * @return The localized date part.
     */
    public function render($duration) {
    	
    	$parts = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(' ', $duration);
    	foreach ($parts as $part) {
    		if(!is_numeric($part)) {
    			$llKey = 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang.xlf:tx_vjeventdb3_duration.' . $part;
    			$replacement = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($llKey, '');
    			$duration = str_replace($part, $replacement, $duration);
    		} 
    	}
		return $duration;
    }
}
?>