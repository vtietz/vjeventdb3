<?php
namespace VJmedia\Vjeventdb3\Domain\Model;

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
 * Price
 */
class Price extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * name
	 *
	 * @var string
	 */
	protected $name = '';

	/**
	 * price
	 *
	 * @var string
	 */
	protected $price = '';

	/**
	 * priceCategory
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\VJmedia\Vjeventdb3\Domain\Model\PriceCategory>
	 */
	protected $priceCategory = NULL;

	/**
	 * priceUnit
	 *
	 * @var \VJmedia\Vjeventdb3\Domain\Model\PriceUnit
	 */
	protected $priceUnit = NULL;

	/**
	 * priceAmount
	 *
	 * @var \VJmedia\Vjeventdb3\Domain\Model\PriceAmount
	 */
	protected $priceAmount = NULL;

	/**
	 * __construct
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all ObjectStorage properties
	 * Do not modify this method!
	 * It will be rewritten on each save in the extension builder
	 * You may modify the constructor of this class instead
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		$this->priceCategory = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Returns the name
	 *
	 * @return string $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets the name
	 *
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Returns the price
	 *
	 * @return string $price
	 */
	public function getPrice() {
		return $this->price;
	}

	/**
	 * Sets the price
	 *
	 * @param string $price
	 * @return void
	 */
	public function setPrice($price) {
		$this->price = $price;
	}

	/**
	 * Adds a PriceCategory
	 *
	 * @param \VJmedia\Vjeventdb3\Domain\Model\PriceCategory $priceCategory
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\VJmedia\Vjeventdb3\Domain\Model\PriceCategory> priceCategory
	 */
	public function addPriceCategory($priceCategory) {
		$this->priceCategory->attach($priceCategory);
	}

	/**
	 * Removes a PriceCategory
	 *
	 * @param \VJmedia\Vjeventdb3\Domain\Model\PriceCategory $priceCategoryToRemove The PriceCategory to be removed
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\VJmedia\Vjeventdb3\Domain\Model\PriceCategory> priceCategory
	 */
	public function removePriceCategory($priceCategoryToRemove) {
		$this->priceCategory->detach($priceCategoryToRemove);
	}

	/**
	 * Returns the priceCategory
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\VJmedia\Vjeventdb3\Domain\Model\PriceCategory> priceCategory
	 */
	public function getPriceCategory() {
		return $this->priceCategory;
	}

	/**
	 * Sets the priceCategory
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\VJmedia\Vjeventdb3\Domain\Model\PriceCategory> $priceCategory
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\VJmedia\Vjeventdb3\Domain\Model\PriceCategory> priceCategory
	 */
	public function setPriceCategory(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $priceCategory) {
		$this->priceCategory = $priceCategory;
	}

	/**
	 * Returns the priceUnit
	 *
	 * @return \VJmedia\Vjeventdb3\Domain\Model\PriceUnit $priceUnit
	 */
	public function getPriceUnit() {
		return $this->priceUnit;
	}

	/**
	 * Sets the priceUnit
	 *
	 * @param \VJmedia\Vjeventdb3\Domain\Model\PriceUnit $priceUnit
	 * @return void
	 */
	public function setPriceUnit(\VJmedia\Vjeventdb3\Domain\Model\PriceUnit $priceUnit) {
		$this->priceUnit = $priceUnit;
	}

	/**
	 * Returns the priceAmount
	 *
	 * @return \VJmedia\Vjeventdb3\Domain\Model\PriceAmount $priceAmount
	 */
	public function getPriceAmount() {
		return $this->priceAmount;
	}

	/**
	 * Sets the priceAmount
	 *
	 * @param \VJmedia\Vjeventdb3\Domain\Model\PriceAmount $priceAmount
	 * @return void
	 */
	public function setPriceAmount(\VJmedia\Vjeventdb3\Domain\Model\PriceAmount $priceAmount) {
		$this->priceAmount = $priceAmount;
	}

}