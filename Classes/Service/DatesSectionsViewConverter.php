<?php
namespace VJmedia\Vjeventdb3\Service;

use VJmedia\Vjeventdb3\Domain\ViewModel\EventsView;
use VJmedia\Vjeventdb3\Domain\ViewModel\SectionsView;

class DatesSectionsViewConverter {

	const LEVEL_DAY = 0;
	const LEVEL_WEEK = 1;
	const LEVEL_MONTH = 2;
	const LEVEL_YEAR = 3;

	/**
	 * @var \VJmedia\Vjeventdb3\Service\DateService
	 */
	protected $dateService = NULL;
	
	function __construct() {
		$this->dateService = new DateService();
	}
	
	/**
	 * @param array $dates
	 */
	public function getSectionsView($dates, $starttime, $endtime, $startlevel, $endlevel) {
		
		$sectionsViews = array();

		//if (TYPO3_DLOG)	\TYPO3\CMS\Core\Utility\GeneralUtility::devLog('[write message in english here]', 'extension key');
		
		if($startlevel == $this::LEVEL_YEAR) {
			$yearCount = $this->dateService->getYearsCount($starttime, $endtime);
			for($i = 0; $i<yearCount ;$i++) {
				$sectionView = new SectionsView();
				$sectionView->setSectionTitle(strtotime('Y + ' + $i + ' year', $starttime));
				$sectionsViews[] = $sectionsView;
			}
		}
		
		$eventsView = new EventsView();
		
		
	}
	
}