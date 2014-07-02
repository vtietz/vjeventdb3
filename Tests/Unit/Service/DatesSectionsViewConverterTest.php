<?php

namespace VJmedia\Vjeventdb3\Tests\Service;

use VJmedia\Vjeventdb3\Tests\Mocks\DateMock;
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
	protected function setUp() {
		$this->subject = new \VJmedia\Vjeventdb3\Service\DatesSectionsViewConverter();
	}
	protected function tearDown() {
		unset($this->subject);
	}
	
	/**
	 * @test
	 */
	public function firsttest() {
		$mock = $this->getDateMock(new DateTime("2012-07-08 11:14:15.638276"), time(), 
				new DateTime("2012-07-08 11:14:15.889342"), time(), 0);
		$this->assertTrue(true);
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