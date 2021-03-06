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
 * Test case for class \VJmedia\Vjeventdb3\Domain\Model\Performer.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Vincent Tietz <vincent.tietz@vj-media.de>
 */
class PerformerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	/**
	 * @var \VJmedia\Vjeventdb3\Domain\Model\Performer
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = new \VJmedia\Vjeventdb3\Domain\Model\Performer();
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
		$this->assertEquals(
			NULL,
			$this->subject->getImages()
		);
	}

	/**
	 * @test
	 */
	public function setImagesForFileReferenceSetsImages() {
		$fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
		$this->subject->setImages($fileReferenceFixture);

		$this->assertAttributeEquals(
			$fileReferenceFixture,
			'images',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getPerformerCategoryReturnsInitialValueForPerformerCategory() {
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getPerformerCategory()
		);
	}

	/**
	 * @test
	 */
	public function setPerformerCategoryForObjectStorageContainingPerformerCategorySetsPerformerCategory() {
		$performerCategory = new \VJmedia\Vjeventdb3\Domain\Model\PerformerCategory();
		$objectStorageHoldingExactlyOnePerformerCategory = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOnePerformerCategory->attach($performerCategory);
		$this->subject->setPerformerCategory($objectStorageHoldingExactlyOnePerformerCategory);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOnePerformerCategory,
			'performerCategory',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addPerformerCategoryToObjectStorageHoldingPerformerCategory() {
		$performerCategory = new \VJmedia\Vjeventdb3\Domain\Model\PerformerCategory();
		$performerCategoryObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$performerCategoryObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($performerCategory));
		$this->inject($this->subject, 'performerCategory', $performerCategoryObjectStorageMock);

		$this->subject->addPerformerCategory($performerCategory);
	}

	/**
	 * @test
	 */
	public function removePerformerCategoryFromObjectStorageHoldingPerformerCategory() {
		$performerCategory = new \VJmedia\Vjeventdb3\Domain\Model\PerformerCategory();
		$performerCategoryObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$performerCategoryObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($performerCategory));
		$this->inject($this->subject, 'performerCategory', $performerCategoryObjectStorageMock);

		$this->subject->removePerformerCategory($performerCategory);

	}
}
