<?php 

namespace VJmedia\Vjeventdb3\ViewHelper;
 
use \DateTime;
use \VJmedia\Vjeventdb3\Domain\Model\Date;
use \VJmedia\Vjeventdb3\ViewHelper\TimestampViewHelper;
use \VJmedia\Vjeventdb3\ViewHelper\TranslateDateViewHelper;

/**
 * Example
 * {namespace m=VJmedia\Vjeventdb3\ViewHelper}
 * <m:dateItem date="\VJmedia\Vjeventdb3\Domain\Model\Date" showStartDay = "true" timeFormat = "H:i" adjustFrontendTime = "-1 hour" />
 */
class DateItemViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * Current TranslateDateViewHelper.
	 *
	 * @var \VJmedia\Vjeventdb3\ViewHelper\TranslateDateViewHelper
	 */
	protected $translateDateViewHelper;
	
	/**
	 * Current TimestampViewHelper.
	 *
	 * @var \VJmedia\Vjeventdb3\ViewHelper\TimestampViewHelper
	 */
	protected $timestampViewHelper;
	
	/**
	 * Inject a TranslateDateViewHelper
	 *
	 * @param \VJmedia\Vjeventdb3\ViewHelper\TranslateDateViewHelper $translateDateViewHelper TranslateDateViewHelper
	 */
	public function injectTranslateDateViewHelper(\VJmedia\Vjeventdb3\ViewHelper\TranslateDateViewHelper $translateDateViewHelper) {
		$this->translateDateViewHelper = $translateDateViewHelper;
	}
	
	/**
	 * Inject a TimestampViewHelper
	 *
	 * @param \VJmedia\Vjeventdb3\ViewHelper\TimestampViewHelper $timestampViewHelper TimestampViewHelper
	 */
	public function injectTimestampViewHelper(\VJmedia\Vjeventdb3\ViewHelper\TimestampViewHelper $timestampViewHelper) {
		$this->timestampViewHelper = $timestampViewHelper;
	}
	
     /**
     * Renders a part of a date using the given language key suffix.
     *
     * @param \DateTime The date.
     * @param string True if start day shoudl be shown. 
     * @param string The time format.
     * @param string Time adjustment.
     * @return The localized date part.
     */
    public function render(\VJmedia\Vjeventdb3\Domain\Model\Date $date = NULL, $showStartDay = '', $timeFormat = '', $adjustFrontendTime = '') {
    	
    	if(empty($date)) {
    		return '';
    	}
    	
    	$value = '';
    	
    	if($date->getFrequency() == 0) {
    		$format = $this->getLL('tx_vjeventdb3_domain_model_date.once');
    		$value .= date($format, $date->getStartDate()->getTimestamp());
    		$value .= ' ';
    	}

		if($showStartDay) {
			if(date('U', $date->getEndDate())) {
				$value .= $this->getLL('tx_vjeventdb3_domain_model_date.From');
			}
			else {
				$value .= $this->getLL('tx_vjeventdb3_domain_model_date.FromWithEnd');
			}
			$value .= ' ';
			$format = $this->getLL('tx_vjeventdb3_domain_model_date.dateFormat');
			$value .= date($format, $date->getStartDate()->getTimestamp());
			$value .= ' ';
		}
    	
		if($date->getFrequency() == 1) {
			$value .= $this->getLL('tx_vjeventdb3_domain_model_date.daily');
		}
		else if($date->getFrequency() == 2) {
			$value .= $this->getLL('tx_vjeventdb3_domain_model_date.every');
			$value .= ' ';
			$value .= date('l', $date->getStartDate()->getTimestamp());
		}
		else if($date->getFrequency() == 3) {
			$value = $value.$this->getLL('tx_vjeventdb3_domain_model_date.every');
			$value .= ' ';
			$value .= date('d.', $date->getStartDate()->getTimestamp());
		}
		else if($date->getFrequency() == 4) {
			$value = $value.$this->getLL('tx_vjeventdb3_domain_model_date.every');
			$value .= ' ';
			$value .= date('d.m.', $date->getStartDate()->getTimestamp());
		}
		$value .= ' ';
		
		if($date->getEndDate()) {
			if(date('U', $date->getEndDate()->getTimestamp())) {
				$value .= $this->getLL('tx_vjeventdb3_domain_model_date.to');
				$value .= ' ';
				$format = $this->getLL('tx_vjeventdb3_domain_model_date.dateFormat');
				$value .= date($format, $date->getEndDate()->getTimestamp());
				$value .= ' ';
				$value .= $this->getLL('tx_vjeventdb3_domain_model_date.clock');
				$value .= ' ';
			}
		}
		
		if($date->getStartTime()) {

			if($date->getEndTime()) {
				$value .= $this->getLL('tx_vjeventdb3_domain_model_date.from');
			}
			else {
				$value .= $this->getLL('tx_vjeventdb3_domain_model_date.at');				
			}
			$value .= ' ';
			$value .= $this->timestampViewHelper->render($date->getStartTime(), $timeFormat, $adjustFrontendTime);
			$value .= ' ';
			$value .= $this->getLL('tx_vjeventdb3_domain_model_date.clock');
		}
		
		if($date->getEndTime()) {
			$value .= ' ';
			$value .= $this->getLL('tx_vjeventdb3_domain_model_date.to');
			$value .= ' ';
			$value .= $this->timestampViewHelper->render($date->getEndTime(), $timeFormat, $adjustFrontendTime);
			$value .= ' ';
			$value .= $this->getLL('tx_vjeventdb3_domain_model_date.clock');
		}
			
		return $this->translateDateViewHelper->translate($value);
		
    }
    
    private function getLL($llKey) {
    	return \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('LLL:EXT:vjeventdb3/Resources/Private/Language/locallang.xlf:'.$llKey, '');
    }
    
}
?>