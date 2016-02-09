<?php

namespace VJmedia\Vjeventdb3\Tests\Unit\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Vincent Tietz <vincent.tietz@vj-media.de>, vjmedia
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class \VJmedia\Vjeventdb3\Domain\Model\ExceptionalDate.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Vincent Tietz <vincent.tietz@vj-media.de>
 */
class ExceptionalDateTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	/**
	 * @var \VJmedia\Vjeventdb3\Domain\Model\ExceptionalDate
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = new \VJmedia\Vjeventdb3\Domain\Model\ExceptionalDate();
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getStartDateReturnsInitialValueForDateTime() {
		$this->assertEquals(
			NULL,
			$this->subject->getStartDate()
		);
	}

	/**
	 * @test
	 */
	public function setStartDateForDateTimeSetsStartDate() {
		$dateTimeFixture = new \DateTime();
		$this->subject->setStartDate($dateTimeFixture);

		$this->assertAttributeEquals(
			$dateTimeFixture,
			'startDate',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getStartTimeReturnsInitialValueForInteger() {
		$this->assertSame(
			0,
			$this->subject->getStartTime()
		);
	}

	/**
	 * @test
	 */
	public function setStartTimeForIntegerSetsStartTime() {
		$this->subject->setStartTime(12);

		$this->assertAttributeEquals(
			12,
			'startTime',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getTitleReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getTitle()
		);
	}

	/**
	 * @test
	 */
	public function setTitleForStringSetsTitle() {
		$this->subject->setTitle('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'title',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getTextReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getText()
		);
	}

	/**
	 * @test
	 */
	public function setTextForStringSetsText() {
		$this->subject->setText('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'text',
			$this->subject
		);
	}
}
