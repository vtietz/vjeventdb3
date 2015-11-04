<?php

namespace VJmedia\Vjeventdb3\ViewHelper;

use \DateTime;

/**
 * Example
 * {namespace m=VJmedia\Vjeventdb3\ViewHelper}
 * <m:translateDate>5. October 2014</m:translateDate> will result in 5. Oktober 2014
 */
class TranslateDateViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {
	
	/**
	 * Translates the date content.
	 * @return Translated content.
	 */
	public function render() {
		$result = $this->renderChildren();
		return $this->translate($result);
		
	}
	
	/**
	 * Translates the content which can contain date names.
	 * @param string $content
	 * @return The translated content.
	 */
	public function translate($content) {
		$parts = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(' ', $content);
    	foreach ($parts as $part) {
    		if(!is_numeric($part)) {
    			$part = str_replace(",", "", $part);
    			$part = str_replace(".", "", $part);
    			$llKey = 'LLL:EXT:vjeventdb3/Resources/Private/Language/locallang.xlf:tx_vjeventdb3_translateDateViewHelper.' . $part;
    			$replacement = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($llKey, '');
    			if($replacement) {
    				$content = str_replace($part, $replacement, $content);
    			}
    		} 
    	}
    	return $content;
	}
}
?>