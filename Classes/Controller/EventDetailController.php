<?php
namespace VJmedia\Vjeventdb3\Controller;

use VJmedia\Vjeventdb3\Domain\Repository\DateRepository;
use VJmedia\Vjeventdb3\Domain\Repository\PriceCategoryRepository;
use VJmedia\Vjeventdb3\Service\DateService;
use VJmedia\Vjeventdb3\Domain\ViewModel\YearSectionView;
use VJmedia\Vjeventdb3\Domain\ViewModel\MonthSectionView;
use VJmedia\Vjeventdb3\Domain\ViewModel\DaySectionView;
use DateTime;
use VJmedia\Vjeventdb3\Service\DateUtils;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 Vincent Tietz <vincent.tietz@vj-media.de>, vjmedia
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * EventDetailController
 */
class EventDetailController extends \VJmedia\Vjeventdb3\Controller\AbstractEventListController {

	/**
	 * action show
	 *
	 * @param \VJmedia\Vjeventdb3\Domain\Model\Event $event
	 * @param \VJmedia\Vjeventdb3\Domain\Model\Date $date
	 * @return void
	 */
	public function showAction(\VJmedia\Vjeventdb3\Domain\Model\Event $event, \VJmedia\Vjeventdb3\Domain\Model\Date $date) {

		$this->view->assign('event', $event);
		$this->view->assign('date', $date);
		
		if($this->anyDateShouldBeShown()) {
		
			$maxItemsPerDate = max(
					$this->getSetting('show.allDates.maxItems', 10),
					$this->getSetting('show.nextDates.maxItems', 10),
					$this->getSetting('show.nextDate.maxItems', 10)
			);
			
			$minStartTimestamp = min(
					$this->getTimestampFromSetting('show.allDates.startTime'),
					$this->getTimestampFromSetting('show.nextDates.startTime'),
					$this->getTimestampFromSetting('show.nextDate.startTime')
			);
	
			$maxEndTimestamp = max(
					$this->getTimestampFromSetting('show.allDates.endTime'),
					$this->getTimestampFromSetting('show.nextDates.endTime'),
					$this->getTimestampFromSetting('show.nextDate.endTime')
			);
			
			$dates = $this->getDatesOfEvent(
					$event, 
					$this->getDateTimeFromTimestamp($minStartTimestamp), 
					$this->getDateTimeFromTimestamp($maxEndTimestamp), 
					$maxItemsPerDate
			);
			
			
			$allDates = $this->getDateService()->getDatesWithinRange($dates,
					$this->getTimestampFromSetting('show.allDates.startTime'),
					$this->getTimestampFromSetting('show.allDates.endTime'),
					$this->getSetting('show.allDates.maxItems', 10)
			);
	
			$nextDates = $this->getDateService()->getDatesWithinRange($dates,
					$this->getTimestampFromSetting('show.nextDates.startTime'),
					$this->getTimestampFromSetting('show.nextDates.endTime'),
					$this->getSetting('show.nextDates.maxItems', 10)
			);
			
			$nextDate = $this->getDateService()->getDatesWithinRange($dates,
					$this->getTimestampFromSetting('show.nextDate.startTime'),
					$this->getTimestampFromSetting('show.nextDate.endTime'),
					$this->getSetting('show.nextDate.maxItems', 10)
			);		
			
			$this->view->assign('alldates', $this->getSetting('show.allDates.show') ? $allDates : '');
			$this->view->assign('nextdates', $this->getSetting('show.nextDates.show') ? $nextDates : '');
			$this->view->assign('nextdate', $this->getSetting('show.nextDate.show') ? $nextDate : '');
			
		}
		
		$this->view->assign('prices', $prices);
		$this->view->assign('priceCategories', $this->getPriceCategories($event->getPrices()));
		$this->view->assign('showAnyDate', $this->anyDateShouldBeShown());
		$this->assignPageUids();
		
	}
	
	private function anyDateShouldBeShown() {
		return $this->getSetting('show.dates.show') || $this->getSetting('show.allDates.show') || $this->getSetting('show.nextDates.show') || $this->getSetting('show.nextDate.show');
	}
	
	public function getPriceCategories($prices) {
		$priceCategories = array();
		foreach ($prices as $price) {
			$cuid = '';
			if($price->getPriceCategory()) {
				$cuid = $price->getPriceCategory()->getUid();
			}
			if(!$priceCategories[$cuid]) {
				$priceCategories[$cuid] = array();
				// why is field sorting null if we would use the extbase repo here? NASS-41
				$priceCategories[$cuid]['category'] = $this->getPriceCategoryFromDB($cuid);
				$priceCategories[$cuid]['prices'] = array();
			}
			$priceCategories[$cuid]['prices'][] = $price;
		}
		$compare = function($a, $b) {
			return $a['category']['sorting'] < $b['category']['sorting'] ? -1 : 1;
		};
		usort($priceCategories, $compare);
		return $priceCategories;
	}
	
	private function getPriceCategoryFromDB($uid) {
		
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
				'*',
				'tx_vjeventdb3_domain_model_pricecategory',
				'uid = '.$uid,
				'',
				''
		);
		
		if (!$GLOBALS['TYPO3_DB']->sql_error()) {
			$result =  $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
			$GLOBALS['TYPO3_DB']->sql_free_result($res);
			return $result;
		}
		
		return null;
	}
	

}