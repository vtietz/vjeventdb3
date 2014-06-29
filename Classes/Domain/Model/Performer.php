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
 * Performer
 */
class Performer extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * name
	 *
	 * @var string
	 */
	protected $name = '';

	/**
	 * description
	 *
	 * @var string
	 */
	protected $description = '';

	/**
	 * images
	 *
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	protected $images = NULL;

	/**
	 * performerCategory
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\VJmedia\Vjeventdb3\Domain\Model\PerformerCategory>
	 */
	protected $performerCategory = NULL;

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
		$this->performerCategory = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
	 * Returns the images
	 *
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $images
	 */
	public function getImages() {
		return $this->images;
	}

	/**
	 * Sets the images
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $images
	 * @return void
	 */
	public function setImages(\TYPO3\CMS\Extbase\Domain\Model\FileReference $images) {
		$this->images = $images;
	}

	/**
	 * Adds a PerformerCategory
	 *
	 * @param \VJmedia\Vjeventdb3\Domain\Model\PerformerCategory $performerCategory
	 * @return void
	 */
	public function addPerformerCategory(\VJmedia\Vjeventdb3\Domain\Model\PerformerCategory $performerCategory) {
		$this->performerCategory->attach($performerCategory);
	}

	/**
	 * Removes a PerformerCategory
	 *
	 * @param \VJmedia\Vjeventdb3\Domain\Model\PerformerCategory $performerCategoryToRemove The PerformerCategory to be removed
	 * @return void
	 */
	public function removePerformerCategory(\VJmedia\Vjeventdb3\Domain\Model\PerformerCategory $performerCategoryToRemove) {
		$this->performerCategory->detach($performerCategoryToRemove);
	}

	/**
	 * Returns the performerCategory
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\VJmedia\Vjeventdb3\Domain\Model\PerformerCategory> $performerCategory
	 */
	public function getPerformerCategory() {
		return $this->performerCategory;
	}

	/**
	 * Sets the performerCategory
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\VJmedia\Vjeventdb3\Domain\Model\PerformerCategory> $performerCategory
	 * @return void
	 */
	public function setPerformerCategory(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $performerCategory) {
		$this->performerCategory = $performerCategory;
	}

}