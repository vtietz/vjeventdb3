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
 * EventController
 */
class EventController extends \VJmedia\Vjeventdb3\Controller\AbstractEventListController {

	/**
	 * eventRepository
	 *
	 * @var \VJmedia\Vjeventdb3\Domain\Repository\EventRepository
	 * @inject
	 */
	protected $eventRepository = NULL;

	/**
	 * dateRepository
	 *
	 * @var \VJmedia\Vjeventdb3\Domain\Repository\DateRepository
	 * @inject
	 */
	protected $dateRepository = NULL;
	
	/**
	 * priceCategoryRepository
	 *
	 * @var \VJmedia\Vjeventdb3\Domain\Repository\PriceCategoryRepository
	 * @inject
	 */
	protected $priceCategoryRepository = NULL;	

	/**
	 * priceRepository
	 *
	 * @var \VJmedia\Vjeventdb3\Domain\Repository\PriceRepository
	 * @inject
	 */
	protected $priceRepository = NULL;
	
	/**
	 * eventCategoryRepository
	 *
	 * @var \VJmedia\Vjeventdb3\Domain\Repository\EventCategoryRepository
	 * @inject
	 */
	protected $eventCategoryRepository = NULL;
	
	/**
	 * ageCategoryRepository
	 *
	 * @var \VJmedia\Vjeventdb3\Domain\Repository\AgeCategoryRepository
	 * @inject
	 */
	protected $ageCategoryRepository = NULL;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {

		$startDateTime = $this->getStartDateTime();
		$endDateTime = $this->getEndDateTime($startDateTime);
		
		$allEventDates = $this->getAllDateEvents($startDateTime, $endDateTime);
		$this->getDateService()->sortDates($allEventDates);
		
		$allEventDates = $this->getDateService()->limitDates($allEventDates, $this->getSetting('maxItems'));
		
		$this->view->assign('dates', $allEventDates);
		$this->view->assign('starttime', $startDateTime);
		$this->view->assign('endtime', $endDateTime);
				
		
		$this->view->assign('years', $this->makeYearSections($allEventDates));
		$this->view->assign('datepickerSettings', $this->getDatePickerSettings($startDateTime));

		$cObjData = $this->configurationManager->getContentObject()->data;
		$this->view->assign('data', $cObjData);
		$this->assignPageUids();
		
	}
	
	private function getDatePickerSettings(\DateTime $startDateTime) {

		$rangeSettings = $this->getCurrentDateRangeSettings();

		$datepickerSettings = array();
		$datepickerSettings['ranges'] = $this->getDatePickerRanges();
		$datepickerSettings['currentRange'] = $this->getCurrentDatePickerRange();
		$datepickerSettings['today'] = date('Y-m-d', strtotime($rangeSettings['today']));
		$datepickerSettings['previous'] = date('Y-m-d', strtotime($rangeSettings['previous'], $startDateTime->getTimestamp()));
		$datepickerSettings['next'] =  date('Y-m-d',  strtotime($rangeSettings['next'], $startDateTime->getTimestamp()));
		$datepickerSettings['regional'] = $this->settings['datepicker']['regional'];
		
		return $datepickerSettings;
		
	}
	
	private function getStartDateTime() {
		$rangeSettings = $this->getCurrentDateRangeSettings();
		$startDateTime = $this->getStartTimeFromArguments($rangeSettings);
		$startDateTime = \VJmedia\Vjeventdb3\Service\DateUtils::dateCorrection($startDateTime, $rangeSettings['startTimeCorrection']);
		return $startDateTime;
	}
	
	private function getEndDateTime(\DateTime $startDateTime) {
		$rangeSettings = $this->getCurrentDateRangeSettings();
		$endtimeString = $this->getArgument('endtime',
				date('Y-m-d 00:00:00', strtotime($rangeSettings['endTimeCorrection'], $startDateTime->getTimestamp())));
		$endDateTime = new DateTime($endtimeString);
		return $endDateTime;
	}
	
	private function getCurrentDateRangeSettings() {
		$range = $this->getCurrentDatePickerRange();
		return $this->settings['datepicker']['ranges'][$range];
	}
	
	private function getDatePickerRanges() {
		$datepickerranges = array();
		foreach($this->settings['datepicker']['ranges'] as $key => $range) {
			$datepickerranges[$key] = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($range['label'], ''); 
		}
		return $datepickerranges;
	}
	
	private function getCurrentDatePickerRange() {
		return $this->getArgument('currentrange', $this->settings['datepicker']['defaultRange']);
	}
	
}