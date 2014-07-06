<?php

namespace VJmedia\Vjeventdb3\Tests\Service;

use VJmedia\Vjeventdb3\Tests\Mocks\DateMock;
use VJmedia\Vjeventdb3\Domain\Model\Date;
use DateTime;

/**
 * Test case for class \VJmedia\Vjeventdb3\Service\DatesSectionsViewConverter.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *         
 * @author Vincent Tietz <vincent.tietz@vj-media.de>
 */
class DatesSectionsViewConverterTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	
	/**
	 *
	 * @var \VJmedia\Vjeventdb3\Service\DatesSectionsViewConverter
	 */
	protected $subject = NULL;
	
	protected $date1 = NULL;
	protected $date2 = NULL;
	protected $date3 = NULL;
	protected $date4 = NULL;
	
	protected function setUp() {
		$this->subject = new \VJmedia\Vjeventdb3\Service\DatesSectionsViewConverter();
	}
	
	protected function tearDown() {
		unset($this->subject);
	}
	
	
	
	/**
	 * Tests if the service returns all dates (which have as frequency once) all dates within the given time period.
	 * 
	 * @test
	 */
	public function onceTest() {
		
		$dates = array(
			// dates in range
			$this->getDateMock(new DateTime("2012-01-01"), strtotime("10:00"), new DateTime("2012-01-01"), strtotime("11:00"), Date::FREQUENCY_ONCE),
			$this->getDateMock(new DateTime("2012-01-05"), strtotime("10:00"), new DateTime("2012-01-05"), strtotime("11:00"), Date::FREQUENCY_ONCE),
			// dates after range
			$this->getDateMock(new DateTime("2013-01-05"), strtotime("10:00"), new DateTime("2013-01-05"), strtotime("11:00"), Date::FREQUENCY_ONCE),
			// dates before range		
			$this->getDateMock(new DateTime("2010-01-05"), strtotime("10:00"), new DateTime("2010-01-05"), strtotime("11:00"), Date::FREQUENCY_ONCE),
		);
		
		// get dates within a range
		$allDates = $this->subject->getAllDates($dates, new DateTime("2012-01-01"), new DateTime("2012-12-31"));
		
		// there should be only two dates 
		$this->assertEquals(2, count($allDates));
	}
	
	/**
	 * Tests if the service returns all dates (which have as frequency once) all dates within the given time period.
	 *
	 * @test
	 */
	public function onceNoDateEndTest() {
	
		$dates = array(
			$this->getDateMock(new DateTime("2012-01-01"), strtotime("10:00"), new DateTime("0000-00-00"), strtotime("11:00"), Date::FREQUENCY_ONCE),
		);
	
		// get dates within a range
		$allDates = $this->subject->getAllDates($dates, new DateTime("2012-01-01"), new DateTime("2012-12-31"));
	
		// there should be only two dates
		$this->assertEquals(1, count($allDates));
	}	
	
	
	/**
	 * Tests if the service returns all dates (which have as frequency daily) all dates within the given time period.
	 *
	 * @test
	 */
	public function dailyTest() {
	
		$dates = array(
			$this->getDateMock(new DateTime("2012-01-01"), strtotime("10:00"), new DateTime("2012-01-05"), strtotime("11:00"), Date::FREQUENCY_DAILY),
		);
	
		// get dates within a range
		$allDates = $this->subject->getAllDates($dates, new DateTime("2012-01-01"), new DateTime("2012-01-31"));
	
		// there should be only two dates
		$this->assertEquals(5, count($allDates));
	}
		
	/**
	 * Tests if the service returns all dates (which have as frequency weekly) all dates within the given time period.
	 *
	 * @test
	 */
	public function weeklyTest() {
	
		$dates = array(
				$this->getDateMock(new DateTime("2014-01-01"), strtotime("10:00"), new DateTime("2014-01-22"), strtotime("11:00"), Date::FREQUENCY_WEEKLY),
		);
	
		// get dates within a range
		$allDates = $this->subject->getAllDates($dates, new DateTime("2014-01-01"), new DateTime("2014-01-31"));
	
		// there should be only two dates
		$this->assertEquals(4, count($allDates));
	}	


	/**
	 * Tests if the service returns all dates (which have as frequency monthly) all dates within the given time period.
	 *
	 * @test
	 */
	public function monthlyTest() {
	
		$dates = array(
				$this->getDateMock(new DateTime("2014-01-01"), strtotime("10:00"), new DateTime("2014-06-01"), strtotime("11:00"), Date::FREQUENCY_MONTHLY),
		);
	
		// get dates within a range
		$allDates = $this->subject->getAllDates($dates, new DateTime("2014-01-01"), new DateTime("2014-06-30"));
	
		// there should be only two dates
		$this->assertEquals(6, count($allDates));
	}
	
	/**
	 * Tests if the service returns all dates (which have as frequency yearly) all dates within the given time period.
	 *
	 * @test
	 */
	public function yearlyTest() {
	
		$dates = array(
				$this->getDateMock(new DateTime("2014-01-01"), strtotime("10:00"), new DateTime("2016-06-01"), strtotime("11:00"), Date::FREQUENCY_YEARLY),
		);
	
		// get dates within a range
		$allDates = $this->subject->getAllDates($dates, new DateTime("2014-01-01"), new DateTime("2016-01-01"));
	
		// there should be only two dates
		$this->assertEquals(3, count($allDates));
	}	
	
	private function getEventOfDate($date) {
		
		if($date == $this->date1) {
			return NULL;
		}
		if($date == $this->date2) {
			return NULL;
		}
		if($date == $this->date3) {
			return NULL;
		}
		
		
	}
	
	private function getDateMock($startDate, $startTime, $endDate, $endTime, $frequency) {
		$dateMock = new \VJmedia\Vjeventdb3\Tests\Mocks\DateMock();
		return $dateMock->
			withStartDate($startDate)->
			withStartTime($startTime)->
			withEndDate($endDate)->
			withEndTime($endTime)->
			withFrequencey($frequency)->
			build();
	}
}