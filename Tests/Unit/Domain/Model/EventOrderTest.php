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
 * Test case for class \VJmedia\Vjeventdb3\Domain\Model\EventOrder.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Vincent Tietz <vincent.tietz@vj-media.de>
 */
class EventOrderTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	/**
	 * @var \VJmedia\Vjeventdb3\Domain\Model\EventOrder
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = new \VJmedia\Vjeventdb3\Domain\Model\EventOrder();
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getNameReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getName()
		);
	}

	/**
	 * @test
	 */
	public function setNameForStringSetsName() {
		$this->subject->setName('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'name',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getSurnameReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getSurname()
		);
	}

	/**
	 * @test
	 */
	public function setSurnameForStringSetsSurname() {
		$this->subject->setSurname('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'surname',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getAddressReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getAddress()
		);
	}

	/**
	 * @test
	 */
	public function setAddressForStringSetsAddress() {
		$this->subject->setAddress('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'address',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getTelephoneReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getTelephone()
		);
	}

	/**
	 * @test
	 */
	public function setTelephoneForStringSetsTelephone() {
		$this->subject->setTelephone('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'telephone',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getEmailReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getEmail()
		);
	}

	/**
	 * @test
	 */
	public function setEmailForStringSetsEmail() {
		$this->subject->setEmail('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'email',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getMessageReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getMessage()
		);
	}

	/**
	 * @test
	 */
	public function setMessageForStringSetsMessage() {
		$this->subject->setMessage('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'message',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getAppointmentReturnsInitialValueForDateTime() {
		$this->assertEquals(
			NULL,
			$this->subject->getAppointment()
		);
	}

	/**
	 * @test
	 */
	public function setAppointmentForDateTimeSetsAppointment() {
		$dateTimeFixture = new \DateTime();
		$this->subject->setAppointment($dateTimeFixture);

		$this->assertAttributeEquals(
			$dateTimeFixture,
			'appointment',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getMailtosenderReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getMailtosender()
		);
	}

	/**
	 * @test
	 */
	public function setMailtosenderForStringSetsMailtosender() {
		$this->subject->setMailtosender('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'mailtosender',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getMailtorecipientReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getMailtorecipient()
		);
	}

	/**
	 * @test
	 */
	public function setMailtorecipientForStringSetsMailtorecipient() {
		$this->subject->setMailtorecipient('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'mailtorecipient',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getEventReturnsInitialValueForEvent() {
		$this->assertEquals(
			NULL,
			$this->subject->getEvent()
		);
	}

	/**
	 * @test
	 */
	public function setEventForEventSetsEvent() {
		$eventFixture = new \VJmedia\Vjeventdb3\Domain\Model\Event();
		$this->subject->setEvent($eventFixture);

		$this->assertAttributeEquals(
			$eventFixture,
			'event',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getAgeCategoryReturnsInitialValueForAgeCategory() {
		$this->assertEquals(
			NULL,
			$this->subject->getAgeCategory()
		);
	}

	/**
	 * @test
	 */
	public function setAgeCategoryForAgeCategorySetsAgeCategory() {
		$ageCategoryFixture = new \VJmedia\Vjeventdb3\Domain\Model\AgeCategory();
		$this->subject->setAgeCategory($ageCategoryFixture);

		$this->assertAttributeEquals(
			$ageCategoryFixture,
			'ageCategory',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getDateReturnsInitialValueForDate() {
		$this->assertEquals(
			NULL,
			$this->subject->getDate()
		);
	}

	/**
	 * @test
	 */
	public function setDateForDateSetsDate() {
		$dateFixture = new \VJmedia\Vjeventdb3\Domain\Model\Date();
		$this->subject->setDate($dateFixture);

		$this->assertAttributeEquals(
			$dateFixture,
			'date',
			$this->subject
		);
	}
}
