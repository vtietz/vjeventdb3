<?php
namespace VJmedia\Vjeventdb3\Controller;

use VJmedia\Vjeventdb3\Domain\Repository\PerformerRepository;

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
 * EventTeaserController
 */
class EventTeaserController extends \VJmedia\Vjeventdb3\Controller\AbstractEventListController {

	/**
	 * eventRepository
	 *
	 * @var \VJmedia\Vjeventdb3\Domain\Repository\EventRepository
	 * @inject
	 */
	protected $eventRepository = NULL;
	
	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		
		$this->setTemplatePaths($this->settings['teaser']);

		$startTimestamp = $this->getTimestampFromSetting('teaser.startTime');
		$startDateTime = $this->getDateTimeFromTimestamp($startTimestamp);
		$endTimestamp = strtotime($this->getSetting('teaser.endTime'), $startDateTime->getTimestamp());
		$endDateTime = $this->getDateTimeFromTimestamp($endTimestamp);
		
		$allEventDates = $this->getAllDateEvents($startDateTime, $endDateTime);
		$this->getDateService()->sortDates($allEventDates);
		$allEventDates = $this->getDateService()->limitDates($allEventDates, $this->getSetting('maxItems'));
		
		$this->view->assign('dates', $allEventDates);
		$this->view->assign('starttime', $startDateTime);
		$this->view->assign('endtime', $endDateTime);
		$this->view->assign('years', $this->makeYearSections($allEventDates));
		$this->assignPageUids();
		
	}
	
}