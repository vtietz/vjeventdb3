<?php
namespace VJmedia\Vjeventdb3\Domain\Model;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016 Vincent Tietz <vincent.tietz@vj-media.de>, vjmedia
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
 * ExceptionalDate
 */
class ExceptionalDate extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * startDate
	 *
	 * @var \DateTime
	 * @validate NotEmpty
	 */
	protected $startDate = NULL;

	/**
	 * startTime
	 *
	 * @var integer
	 */
	protected $startTime = 0;

	/**
	 * title
	 *
	 * @var string
	 */
	protected $title = '';

	/**
	 * text
	 *
	 * @var string
	 */
	protected $text = '';

	/**
	 * Returns the startDate
	 *
	 * @return \DateTime $startDate
	 */
	public function getStartDate() {
		return $this->startDate;
	}

	/**
	 * Sets the startDate
	 *
	 * @param \DateTime $startDate
	 * @return void
	 */
	public function setStartDate(\DateTime $startDate) {
		$this->startDate = $startDate;
	}

	/**
	 * Returns the startTime
	 *
	 * @return integer $startTime
	 */
	public function getStartTime() {
		return $this->startTime;
	}

	/**
	 * Sets the startTime
	 *
	 * @param integer $startTime
	 * @return void
	 */
	public function setStartTime(integer $startTime) {
		$this->startTime = $startTime;
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
	 * Returns the text
	 *
	 * @return string $text
	 */
	public function getText() {
		return $this->text;
	}

	/**
	 * Sets the text
	 *
	 * @param string $text
	 * @return void
	 */
	public function setText($text) {
		$this->text = $text;
	}

}