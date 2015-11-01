<?php

namespace VJmedia\Vjeventdb3\Tests\Unit\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Vincent Tietz <vincent.tietz@vj-media.de>, vjmedia
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
 * Test case for class \VJmedia\Vjeventdb3\Domain\Model\Price.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Vincent Tietz <vincent.tietz@vj-media.de>
 */
class PriceTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	/**
	 * @var \VJmedia\Vjeventdb3\Domain\Model\Price
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = new \VJmedia\Vjeventdb3\Domain\Model\Price();
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
	public function getPriceReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getPrice()
		);
	}

	/**
	 * @test
	 */
	public function setPriceForStringSetsPrice() {
		$this->subject->setPrice('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'price',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getPriceCategoryReturnsInitialValueForPriceCategory() {
		$this->assertEquals(
			NULL,
			$this->subject->getPriceCategory()
		);
	}

	/**
	 * @test
	 */
	public function setPriceCategoryForPriceCategorySetsPriceCategory() {
		$priceCategoryFixture = new \VJmedia\Vjeventdb3\Domain\Model\PriceCategory();
		$this->subject->setPriceCategory($priceCategoryFixture);

		$this->assertAttributeEquals(
			$priceCategoryFixture,
			'priceCategory',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getPriceUnitReturnsInitialValueForPriceUnit() {
		$this->assertEquals(
			NULL,
			$this->subject->getPriceUnit()
		);
	}

	/**
	 * @test
	 */
	public function setPriceUnitForPriceUnitSetsPriceUnit() {
		$priceUnitFixture = new \VJmedia\Vjeventdb3\Domain\Model\PriceUnit();
		$this->subject->setPriceUnit($priceUnitFixture);

		$this->assertAttributeEquals(
			$priceUnitFixture,
			'priceUnit',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getPriceAmountReturnsInitialValueForPriceAmount() {
		$this->assertEquals(
			NULL,
			$this->subject->getPriceAmount()
		);
	}

	/**
	 * @test
	 */
	public function setPriceAmountForPriceAmountSetsPriceAmount() {
		$priceAmountFixture = new \VJmedia\Vjeventdb3\Domain\Model\PriceAmount();
		$this->subject->setPriceAmount($priceAmountFixture);

		$this->assertAttributeEquals(
			$priceAmountFixture,
			'priceAmount',
			$this->subject
		);
	}
}
