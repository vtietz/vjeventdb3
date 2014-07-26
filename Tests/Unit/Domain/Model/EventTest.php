<?php

namespace VJmedia\Vjeventdb3\Tests\Unit\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Vincent Tietz <vincent.tietz@vj-media.de>, vjmedia
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
 * Test case for class \VJmedia\Vjeventdb3\Domain\Model\Event.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Vincent Tietz <vincent.tietz@vj-media.de>
 */
class EventTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	/**
	 * @var \VJmedia\Vjeventdb3\Domain\Model\Event
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = new \VJmedia\Vjeventdb3\Domain\Model\Event();
	}

	protected function tearDown() {
		unset($this->subject);
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
	public function getSubtitleReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getSubtitle()
		);
	}

	/**
	 * @test
	 */
	public function setSubtitleForStringSetsSubtitle() {
		$this->subject->setSubtitle('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'subtitle',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getTeasertextReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getTeasertext()
		);
	}

	/**
	 * @test
	 */
	public function setTeasertextForStringSetsTeasertext() {
		$this->subject->setTeasertext('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'teasertext',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getDescriptionReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getDescription()
		);
	}

	/**
	 * @test
	 */
	public function setDescriptionForStringSetsDescription() {
		$this->subject->setDescription('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'description',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getImagesReturnsInitialValueForFileReference() {
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getImages()
		);
	}

	/**
	 * @test
	 */
	public function setImagesForFileReferenceSetsImages() {
		$image = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
		$objectStorageHoldingExactlyOneImages = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneImages->attach($image);
		$this->subject->setImages($objectStorageHoldingExactlyOneImages);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneImages,
			'images',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addImageToObjectStorageHoldingImages() {
		$image = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
		$imagesObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$imagesObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($image));
		$this->inject($this->subject, 'images', $imagesObjectStorageMock);

		$this->subject->addImage($image);
	}

	/**
	 * @test
	 */
	public function removeImageFromObjectStorageHoldingImages() {
		$image = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
		$imagesObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$imagesObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($image));
		$this->inject($this->subject, 'images', $imagesObjectStorageMock);

		$this->subject->removeImage($image);

	}

	/**
	 * @test
	 */
	public function getTeaserImagesReturnsInitialValueForFileReference() {
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getTeaserImages()
		);
	}

	/**
	 * @test
	 */
	public function setTeaserImagesForFileReferenceSetsTeaserImages() {
		$teaserImage = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
		$objectStorageHoldingExactlyOneTeaserImages = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneTeaserImages->attach($teaserImage);
		$this->subject->setTeaserImages($objectStorageHoldingExactlyOneTeaserImages);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneTeaserImages,
			'teaserImages',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addTeaserImageToObjectStorageHoldingTeaserImages() {
		$teaserImage = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
		$teaserImagesObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$teaserImagesObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($teaserImage));
		$this->inject($this->subject, 'teaserImages', $teaserImagesObjectStorageMock);

		$this->subject->addTeaserImage($teaserImage);
	}

	/**
	 * @test
	 */
	public function removeTeaserImageFromObjectStorageHoldingTeaserImages() {
		$teaserImage = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
		$teaserImagesObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$teaserImagesObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($teaserImage));
		$this->inject($this->subject, 'teaserImages', $teaserImagesObjectStorageMock);

		$this->subject->removeTeaserImage($teaserImage);

	}

	/**
	 * @test
	 */
	public function getLocationReturnsInitialValueForLocation() {
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getLocation()
		);
	}

	/**
	 * @test
	 */
	public function setLocationForObjectStorageContainingLocationSetsLocation() {
		$location = new \VJmedia\Vjeventdb3\Domain\Model\Location();
		$objectStorageHoldingExactlyOneLocation = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneLocation->attach($location);
		$this->subject->setLocation($objectStorageHoldingExactlyOneLocation);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneLocation,
			'location',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addLocationToObjectStorageHoldingLocation() {
		$location = new \VJmedia\Vjeventdb3\Domain\Model\Location();
		$locationObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$locationObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($location));
		$this->inject($this->subject, 'location', $locationObjectStorageMock);

		$this->subject->addLocation($location);
	}

	/**
	 * @test
	 */
	public function removeLocationFromObjectStorageHoldingLocation() {
		$location = new \VJmedia\Vjeventdb3\Domain\Model\Location();
		$locationObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$locationObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($location));
		$this->inject($this->subject, 'location', $locationObjectStorageMock);

		$this->subject->removeLocation($location);

	}

	/**
	 * @test
	 */
	public function getDatesReturnsInitialValueForDate() {
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getDates()
		);
	}

	/**
	 * @test
	 */
	public function setDatesForObjectStorageContainingDateSetsDates() {
		$date = new \VJmedia\Vjeventdb3\Domain\Model\Date();
		$objectStorageHoldingExactlyOneDates = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneDates->attach($date);
		$this->subject->setDates($objectStorageHoldingExactlyOneDates);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneDates,
			'dates',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addDateToObjectStorageHoldingDates() {
		$date = new \VJmedia\Vjeventdb3\Domain\Model\Date();
		$datesObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$datesObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($date));
		$this->inject($this->subject, 'dates', $datesObjectStorageMock);

		$this->subject->addDate($date);
	}

	/**
	 * @test
	 */
	public function removeDateFromObjectStorageHoldingDates() {
		$date = new \VJmedia\Vjeventdb3\Domain\Model\Date();
		$datesObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$datesObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($date));
		$this->inject($this->subject, 'dates', $datesObjectStorageMock);

		$this->subject->removeDate($date);

	}

	/**
	 * @test
	 */
	public function getEventCategoryReturnsInitialValueForEventCategory() {
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getEventCategory()
		);
	}

	/**
	 * @test
	 */
	public function setEventCategoryForObjectStorageContainingEventCategorySetsEventCategory() {
		$eventCategory = new \VJmedia\Vjeventdb3\Domain\Model\EventCategory();
		$objectStorageHoldingExactlyOneEventCategory = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneEventCategory->attach($eventCategory);
		$this->subject->setEventCategory($objectStorageHoldingExactlyOneEventCategory);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneEventCategory,
			'eventCategory',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addEventCategoryToObjectStorageHoldingEventCategory() {
		$eventCategory = new \VJmedia\Vjeventdb3\Domain\Model\EventCategory();
		$eventCategoryObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$eventCategoryObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($eventCategory));
		$this->inject($this->subject, 'eventCategory', $eventCategoryObjectStorageMock);

		$this->subject->addEventCategory($eventCategory);
	}

	/**
	 * @test
	 */
	public function removeEventCategoryFromObjectStorageHoldingEventCategory() {
		$eventCategory = new \VJmedia\Vjeventdb3\Domain\Model\EventCategory();
		$eventCategoryObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$eventCategoryObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($eventCategory));
		$this->inject($this->subject, 'eventCategory', $eventCategoryObjectStorageMock);

		$this->subject->removeEventCategory($eventCategory);

	}

	/**
	 * @test
	 */
	public function getAgeCategoryReturnsInitialValueForAgeCategory() {
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getAgeCategory()
		);
	}

	/**
	 * @test
	 */
	public function setAgeCategoryForObjectStorageContainingAgeCategorySetsAgeCategory() {
		$ageCategory = new \VJmedia\Vjeventdb3\Domain\Model\AgeCategory();
		$objectStorageHoldingExactlyOneAgeCategory = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneAgeCategory->attach($ageCategory);
		$this->subject->setAgeCategory($objectStorageHoldingExactlyOneAgeCategory);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneAgeCategory,
			'ageCategory',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addAgeCategoryToObjectStorageHoldingAgeCategory() {
		$ageCategory = new \VJmedia\Vjeventdb3\Domain\Model\AgeCategory();
		$ageCategoryObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$ageCategoryObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($ageCategory));
		$this->inject($this->subject, 'ageCategory', $ageCategoryObjectStorageMock);

		$this->subject->addAgeCategory($ageCategory);
	}

	/**
	 * @test
	 */
	public function removeAgeCategoryFromObjectStorageHoldingAgeCategory() {
		$ageCategory = new \VJmedia\Vjeventdb3\Domain\Model\AgeCategory();
		$ageCategoryObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$ageCategoryObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($ageCategory));
		$this->inject($this->subject, 'ageCategory', $ageCategoryObjectStorageMock);

		$this->subject->removeAgeCategory($ageCategory);

	}

	/**
	 * @test
	 */
	public function getPricesReturnsInitialValueForPrice() {
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getPrices()
		);
	}

	/**
	 * @test
	 */
	public function setPricesForObjectStorageContainingPriceSetsPrices() {
		$price = new \VJmedia\Vjeventdb3\Domain\Model\Price();
		$objectStorageHoldingExactlyOnePrices = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOnePrices->attach($price);
		$this->subject->setPrices($objectStorageHoldingExactlyOnePrices);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOnePrices,
			'prices',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addPriceToObjectStorageHoldingPrices() {
		$price = new \VJmedia\Vjeventdb3\Domain\Model\Price();
		$pricesObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$pricesObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($price));
		$this->inject($this->subject, 'prices', $pricesObjectStorageMock);

		$this->subject->addPrice($price);
	}

	/**
	 * @test
	 */
	public function removePriceFromObjectStorageHoldingPrices() {
		$price = new \VJmedia\Vjeventdb3\Domain\Model\Price();
		$pricesObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$pricesObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($price));
		$this->inject($this->subject, 'prices', $pricesObjectStorageMock);

		$this->subject->removePrice($price);

	}

	/**
	 * @test
	 */
	public function getPerformersReturnsInitialValueForPerformer() {
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getPerformers()
		);
	}

	/**
	 * @test
	 */
	public function setPerformersForObjectStorageContainingPerformerSetsPerformers() {
		$performer = new \VJmedia\Vjeventdb3\Domain\Model\Performer();
		$objectStorageHoldingExactlyOnePerformers = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOnePerformers->attach($performer);
		$this->subject->setPerformers($objectStorageHoldingExactlyOnePerformers);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOnePerformers,
			'performers',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addPerformerToObjectStorageHoldingPerformers() {
		$performer = new \VJmedia\Vjeventdb3\Domain\Model\Performer();
		$performersObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$performersObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($performer));
		$this->inject($this->subject, 'performers', $performersObjectStorageMock);

		$this->subject->addPerformer($performer);
	}

	/**
	 * @test
	 */
	public function removePerformerFromObjectStorageHoldingPerformers() {
		$performer = new \VJmedia\Vjeventdb3\Domain\Model\Performer();
		$performersObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$performersObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($performer));
		$this->inject($this->subject, 'performers', $performersObjectStorageMock);

		$this->subject->removePerformer($performer);

	}
}
