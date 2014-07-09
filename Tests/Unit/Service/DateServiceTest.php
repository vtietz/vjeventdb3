<?php

namespace VJmedia\Vjeventdb3\Tests\Service;

use VJmedia\Vjeventdb3\Tests\Mocks\DateMock;
use VJmedia\Vjeventdb3\Domain\Model\Date;
use DateTime;

/**
 * Test case for class \VJmedia\Vjeventdb3\Service\DateService.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *         
 * @author Vincent Tietz <vincent.tietz@vj-media.de>
 */
class DateServiceTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	
	/**
	 *
	 * @var \VJmedia\Vjeventdb3\Service\DateService
	 */
	protected $subject = NULL;
	
	protected function setUp() {
		$this->subject = new \VJmedia\Vjeventdb3\Service\DateService();
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
			DateMock::getDateMock(new DateTime("2012-01-01"), strtotime("10:00"), new DateTime("2012-01-01"), strtotime("11:00"), Date::FREQUENCY_ONCE),
			DateMock::getDateMock(new DateTime("2012-01-05"), strtotime("10:00"), new DateTime("2012-01-05"), strtotime("11:00"), Date::FREQUENCY_ONCE),
			// dates after range
			DateMock::getDateMock(new DateTime("2013-01-05"), strtotime("10:00"), new DateTime("2013-01-05"), strtotime("11:00"), Date::FREQUENCY_ONCE),
			// dates before range		
			DateMock::getDateMock(new DateTime("2010-01-05"), strtotime("10:00"), new DateTime("2010-01-05"), strtotime("11:00"), Date::FREQUENCY_ONCE),
		);
		
		// get dates within a range
		$allDates = $this->subject->getAllDates($dates, new DateTime("2012-01-01"), new DateTime("2012-12-31"));
		
		// there should be only two dates 
		$this->assertEquals(2, count($allDates));
		$this->assertDateTimeEquals(new DateTime("2012-01-01"), $allDates[0]->getStartDate());
		$this->assertDateTimeEquals(new DateTime("2012-01-05"), $allDates[1]->getStartDate());
	}
	
	/**
	 * Tests if the service returns all dates (which have as frequency once) all dates within the given time period.
	 *
	 * @test
	 */
	public function onceNoDateEndTest() {
	
		$dates = array(
			DateMock::getDateMock(new DateTime("2012-01-01"), strtotime("10:00"), new DateTime("0000-00-00"), strtotime("11:00"), Date::FREQUENCY_ONCE),
		);
	
		$allDates = $this->subject->getAllDates($dates, new DateTime("2012-01-01"), new DateTime("2012-12-31"));
	
		$this->assertEquals(1, count($allDates));
		$this->assertDateTimeEquals(new DateTime("2012-01-01"), $allDates[0]->getStartDate());
	}	
	
	
	/**
	 * Tests if the service returns all dates (which have as frequency daily) all dates within the given time period.
	 *
	 * @test
	 */
	public function dailyTest() {
	
		$dates = array(
			DateMock::getDateMock(new DateTime("2012-01-01"), strtotime("10:00"), new DateTime("2012-01-05"), strtotime("11:00"), Date::FREQUENCY_DAILY),
		);
	
		$allDates = $this->subject->getAllDates($dates, new DateTime("2012-01-01"), new DateTime("2012-01-31"));
	
		$this->assertEquals(5, count($allDates));		
		$this->assertDateTimeEquals(new DateTime("2012-01-01"), $allDates[0]->getStartDate());
		$this->assertDateTimeEquals(new DateTime("2012-01-02"), $allDates[1]->getStartDate());
		$this->assertDateTimeEquals(new DateTime("2012-01-03"), $allDates[2]->getStartDate());
		$this->assertDateTimeEquals(new DateTime("2012-01-04"), $allDates[3]->getStartDate());
		$this->assertDateTimeEquals(new DateTime("2012-01-05"), $allDates[4]->getStartDate());
		
	}
	
	private function assertDateTimeEquals($expectedDateTime, $assertedDateTime) {
		$this->assertEquals($expectedDateTime->format("Y-m-d H:i"), $assertedDateTime->format("Y-m-d H:i"));
	}
		
	/**
	 * Tests if the service returns all dates (which have as frequency weekly) all dates within the given time period.
	 *
	 * @test
	 */
	public function weeklyTest() {
	
		$dates = array(
			DateMock::getDateMock(new DateTime("2014-01-01"), strtotime("10:00"), new DateTime("2014-01-22"), strtotime("11:00"), Date::FREQUENCY_WEEKLY),
		);
	
		$allDates = $this->subject->getAllDates($dates, new DateTime("2014-01-01"), new DateTime("2014-01-31"));
	
		$this->assertEquals(4, count($allDates));
		$this->assertDateTimeEquals(new DateTime("2014-01-01"), $allDates[0]->getStartDate());
		$this->assertDateTimeEquals(new DateTime("2014-01-08"), $allDates[1]->getStartDate());
		$this->assertDateTimeEquals(new DateTime("2014-01-15"), $allDates[2]->getStartDate());
		$this->assertDateTimeEquals(new DateTime("2014-01-22"), $allDates[3]->getStartDate());
	}	


	/**
	 * Tests if the service returns all dates (which have as frequency monthly) all dates within the given time period.
	 *
	 * @test
	 */
	public function monthlyTest() {
	
		$dates = array(
				DateMock::getDateMock(new DateTime("2014-01-01"), strtotime("10:00"), new DateTime("2014-06-01"), strtotime("11:00"), Date::FREQUENCY_MONTHLY),
		);
	
		$allDates = $this->subject->getAllDates($dates, new DateTime("2014-01-01"), new DateTime("2014-06-30"));
	
		$this->assertEquals(6, count($allDates));
		$this->assertDateTimeEquals(new DateTime("2014-01-01"), $allDates[0]->getStartDate());
		$this->assertDateTimeEquals(new DateTime("2014-02-01"), $allDates[1]->getStartDate());
		$this->assertDateTimeEquals(new DateTime("2014-03-01"), $allDates[2]->getStartDate());
		$this->assertDateTimeEquals(new DateTime("2014-04-01"), $allDates[3]->getStartDate());		
		$this->assertDateTimeEquals(new DateTime("2014-05-01"), $allDates[4]->getStartDate());
		$this->assertDateTimeEquals(new DateTime("2014-06-01"), $allDates[5]->getStartDate());		
	}
	
	/**
	 * Tests if the service returns all dates (which have as frequency yearly) all dates within the given time period.
	 *
	 * @test
	 */
	public function yearlyTest() {
	
		$dates = array(
				DateMock::getDateMock(new DateTime("2014-01-01"), strtotime("10:00"), new DateTime("2016-06-01"), strtotime("11:00"), Date::FREQUENCY_YEARLY),
		);
	
		$allDates = $this->subject->getAllDates($dates, new DateTime("2014-01-01"), new DateTime("2016-01-01"));
	
		$this->assertEquals(3, count($allDates));
		$this->assertDateTimeEquals(new DateTime("2014-01-01"), $allDates[0]->getStartDate());
		$this->assertDateTimeEquals(new DateTime("2015-01-01"), $allDates[1]->getStartDate());
		$this->assertDateTimeEquals(new DateTime("2016-01-01"), $allDates[2]->getStartDate());
	}	
	
	/**
	 * Tests if there is only one date with the same start time and if it is the date with maximum sort value.
	 *
	 * @test
	 */
	public function multipleDatesTest() {

		$dates = array(
				DateMock::getDateMock(new DateTime("2014-01-01"), strtotime("10:00"), new DateTime("2016-06-01"), strtotime("11:00"), Date::FREQUENCY_ONCE, 0),
				DateMock::getDateMock(new DateTime("2014-01-01"), strtotime("10:00"), new DateTime("2016-06-01"), strtotime("12:00"), Date::FREQUENCY_ONCE, 1),
				DateMock::getDateMock(new DateTime("2014-01-01"), strtotime("10:00"), new DateTime("2016-06-01"), strtotime("13:00"), Date::FREQUENCY_ONCE, 2),
		);
		
		$allDates = $this->subject->getAllDates($dates, new DateTime("2014-01-01"), new DateTime("2016-01-01"));
		$this->assertEquals(1, count($allDates));
		$this->assertDateTimeEquals(new DateTime("2014-01-01"), $allDates[0]->getStartDate());
		$this->assertEquals(2, $allDates[0]->getSorting());
		
	}
	
}