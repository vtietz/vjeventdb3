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
 * Event
 */
class Event extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * title
	 *
	 * @var string
	 */
	protected $title = '';

	/**
	 * subtitle
	 *
	 * @var string
	 */
	protected $subtitle = '';

	/**
	 * teasertext
	 *
	 * @var string
	 */
	protected $teasertext = '';

	/**
	 * description
	 *
	 * @var string
	 */
	protected $description = '';

	/**
	 * images
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
	 * @cascade remove
	 */
	protected $images = NULL;

	/**
	 * location
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\VJmedia\Vjeventdb3\Domain\Model\Location>
	 */
	protected $location = NULL;

	/**
	 * dates
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\VJmedia\Vjeventdb3\Domain\Model\Date>
	 * @cascade remove
	 */
	protected $dates = NULL;

	/**
	 * eventCategory
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\VJmedia\Vjeventdb3\Domain\Model\EventCategory>
	 */
	protected $eventCategory = NULL;

	/**
	 * ageCategory
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\VJmedia\Vjeventdb3\Domain\Model\AgeCategory>
	 */
	protected $ageCategory = NULL;

	/**
	 * prices
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\VJmedia\Vjeventdb3\Domain\Model\Price>
	 */
	protected $prices = NULL;

	/**
	 * performers
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\VJmedia\Vjeventdb3\Domain\Model\Performer>
	 */
	protected $performers = NULL;

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
		$this->images = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->location = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->dates = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->eventCategory = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->ageCategory = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->prices = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->performers = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Returns the title
	 *
	 * @return string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the subtitle
	 *
	 * @return string $subtitle
	 */
	public function getSubtitle() {
		return $this->subtitle;
	}

	/**
	 * Sets the subtitle
	 *
	 * @param string $subtitle
	 * @return void
	 */
	public function setSubtitle($subtitle) {
		$this->subtitle = $subtitle;
	}

	/**
	 * Returns the teasertext
	 *
	 * @return string $teasertext
	 */
	public function getTeasertext() {
		return $this->teasertext;
	}

	/**
	 * Sets the teasertext
	 *
	 * @param string $teasertext
	 * @return void
	 */
	public function setTeasertext($teasertext) {
		$this->teasertext = $teasertext;
	}

	/**
	 * Returns the description
	 *
	 * @return string $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets the description
	 *
	 * @param string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Adds a FileReference
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
	 * @return void
	 */
	public function addImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $image) {
		$this->images->attach($image);
	}

	/**
	 * Removes a FileReference
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $imageToRemove The FileReference to be removed
	 * @return void
	 */
	public function removeImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $imageToRemove) {
		$this->images->detach($imageToRemove);
	}

	/**
	 * Returns the images
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $images
	 */
	public function getImages() {
		return $this->images;
	}

	/**
	 * Sets the images
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $images
	 * @return void
	 */
	public function setImages(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $images) {
		$this->images = $images;
	}

	/**
	 * Adds a Location
	 *
	 * @param \VJmedia\Vjeventdb3\Domain\Model\Location $location
	 * @return void
	 */
	public function addLocation(\VJmedia\Vjeventdb3\Domain\Model\Location $location) {
		$this->location->attach($location);
	}

	/**
	 * Removes a Location
	 *
	 * @param \VJmedia\Vjeventdb3\Domain\Model\Location $locationToRemove The Location to be removed
	 * @return void
	 */
	public function removeLocation(\VJmedia\Vjeventdb3\Domain\Model\Location $locationToRemove) {
		$this->location->detach($locationToRemove);
	}

	/**
	 * Returns the location
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\VJmedia\Vjeventdb3\Domain\Model\Location> $location
	 */
	public function getLocation() {
		return $this->location;
	}

	/**
	 * Sets the location
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\VJmedia\Vjeventdb3\Domain\Model\Location> $location
	 * @return void
	 */
	public function setLocation(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $location) {
		$this->location = $location;
	}

	/**
	 * Adds a Date
	 *
	 * @param \VJmedia\Vjeventdb3\Domain\Model\Date $date
	 * @return void
	 */
	public function addDate(\VJmedia\Vjeventdb3\Domain\Model\Date $date) {
		$this->dates->attach($date);
	}

	/**
	 * Removes a Date
	 *
	 * @param \VJmedia\Vjeventdb3\Domain\Model\Date $dateToRemove The Date to be removed
	 * @return void
	 */
	public function removeDate(\VJmedia\Vjeventdb3\Domain\Model\Date $dateToRemove) {
		$this->dates->detach($dateToRemove);
	}

	/**
	 * Returns the dates
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\VJmedia\Vjeventdb3\Domain\Model\Date> $dates
	 */
	public function getDates() {
		return $this->dates;
	}

	/**
	 * Sets the dates
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\VJmedia\Vjeventdb3\Domain\Model\Date> $dates
	 * @return void
	 */
	public function setDates(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $dates) {
		$this->dates = $dates;
	}

	/**
	 * Adds a EventCategory
	 *
	 * @param \VJmedia\Vjeventdb3\Domain\Model\EventCategory $eventCategory
	 * @return void
	 */
	public function addEventCategory(\VJmedia\Vjeventdb3\Domain\Model\EventCategory $eventCategory) {
		$this->eventCategory->attach($eventCategory);
	}

	/**
	 * Removes a EventCategory
	 *
	 * @param \VJmedia\Vjeventdb3\Domain\Model\EventCategory $eventCategoryToRemove The EventCategory to be removed
	 * @return void
	 */
	public function removeEventCategory(\VJmedia\Vjeventdb3\Domain\Model\EventCategory $eventCategoryToRemove) {
		$this->eventCategory->detach($eventCategoryToRemove);
	}

	/**
	 * Returns the eventCategory
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\VJmedia\Vjeventdb3\Domain\Model\EventCategory> $eventCategory
	 */
	public function getEventCategory() {
		return $this->eventCategory;
	}

	/**
	 * Sets the eventCategory
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\VJmedia\Vjeventdb3\Domain\Model\EventCategory> $eventCategory
	 * @return void
	 */
	public function setEventCategory(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $eventCategory) {
		$this->eventCategory = $eventCategory;
	}

	/**
	 * Adds a AgeCategory
	 *
	 * @param \VJmedia\Vjeventdb3\Domain\Model\AgeCategory $ageCategory
	 * @return void
	 */
	public function addAgeCategory(\VJmedia\Vjeventdb3\Domain\Model\AgeCategory $ageCategory) {
		$this->ageCategory->attach($ageCategory);
	}

	/**
	 * Removes a AgeCategory
	 *
	 * @param \VJmedia\Vjeventdb3\Domain\Model\AgeCategory $ageCategoryToRemove The AgeCategory to be removed
	 * @return void
	 */
	public function removeAgeCategory(\VJmedia\Vjeventdb3\Domain\Model\AgeCategory $ageCategoryToRemove) {
		$this->ageCategory->detach($ageCategoryToRemove);
	}

	/**
	 * Returns the ageCategory
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\VJmedia\Vjeventdb3\Domain\Model\AgeCategory> $ageCategory
	 */
	public function getAgeCategory() {
		return $this->ageCategory;
	}

	/**
	 * Sets the ageCategory
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\VJmedia\Vjeventdb3\Domain\Model\AgeCategory> $ageCategory
	 * @return void
	 */
	public function setAgeCategory(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $ageCategory) {
		$this->ageCategory = $ageCategory;
	}

	/**
	 * Adds a Price
	 *
	 * @param \VJmedia\Vjeventdb3\Domain\Model\Price $price
	 * @return void
	 */
	public function addPrice(\VJmedia\Vjeventdb3\Domain\Model\Price $price) {
		$this->prices->attach($price);
	}

	/**
	 * Removes a Price
	 *
	 * @param \VJmedia\Vjeventdb3\Domain\Model\Price $priceToRemove The Price to be removed
	 * @return void
	 */
	public function removePrice(\VJmedia\Vjeventdb3\Domain\Model\Price $priceToRemove) {
		$this->prices->detach($priceToRemove);
	}

	/**
	 * Returns the prices
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\VJmedia\Vjeventdb3\Domain\Model\Price> $prices
	 */
	public function getPrices() {
		return $this->prices;
	}

	/**
	 * Sets the prices
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\VJmedia\Vjeventdb3\Domain\Model\Price> $prices
	 * @return void
	 */
	public function setPrices(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $prices) {
		$this->prices = $prices;
	}

	/**
	 * Adds a Performer
	 *
	 * @param \VJmedia\Vjeventdb3\Domain\Model\Performer $performer
	 * @return void
	 */
	public function addPerformer(\VJmedia\Vjeventdb3\Domain\Model\Performer $performer) {
		$this->performers->attach($performer);
	}

	/**
	 * Removes a Performer
	 *
	 * @param \VJmedia\Vjeventdb3\Domain\Model\Performer $performerToRemove The Performer to be removed
	 * @return void
	 */
	public function removePerformer(\VJmedia\Vjeventdb3\Domain\Model\Performer $performerToRemove) {
		$this->performers->detach($performerToRemove);
	}

	/**
	 * Returns the performers
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\VJmedia\Vjeventdb3\Domain\Model\Performer> $performers
	 */
	public function getPerformers() {
		return $this->performers;
	}

	/**
	 * Sets the performers
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\VJmedia\Vjeventdb3\Domain\Model\Performer> $performers
	 * @return void
	 */
	public function setPerformers(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $performers) {
		$this->performers = $performers;
	}

}