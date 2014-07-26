<?php
namespace VJmedia\Vjeventdb3\Domain\Repository;

use \DateTime;

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
 * The repository for Events
 */
class EventRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	/**
	 * @param $startDate The start date
	 * @param $endDate The end date
	 * @param $eventCategories If set only events with these event categories are returned.
	 * @param $ageCategories If set only events with these age categories are returned.
	 */
	public function findAllInDateRange(\DateTime $startDate, \DateTime $endDate, $eventCategories = array(), $ageCategories = array()) {
		
		$query = $this->persistenceManager->createQueryForType($this->objectType);
		
		if ($this->defaultOrderings !== array()) {
			$query->setOrderings($this->defaultOrderings);
		}
		
		if ($this->defaultQuerySettings !== NULL) {
			$query->setQuerySettings(clone $this->defaultQuerySettings);
		}
		
		$query->matching(
			$query->logicalAnd(
				$query->lessThanOrEqual('dates.start_date', date('Y-m-d', $endDate->getTimestamp())),
				$query->logicalOr(
					$query->greaterThanOrEqual('dates.end_date', date('Y-m-d', $startDate->getTimestamp())),
					$query->equals('dates.end_date', '0000-00-00'),
					$query->equals('dates.end_date', NULL)
				)
			)
		);
		
		if(count($eventCategories) > 0) {
			$query->matching($query->in('event_category', $eventCategories));
		}	
		if(count($ageCategory) > 0) {
			$query->matching($query->in('age_category', $ageCategories));
		}
		
		return $query->execute();
	}

}