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
 * EventOrder
 */
class EventOrder extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * name
	 *
	 * @var string
	 */
	protected $name = '';

	/**
	 * surname
	 *
	 * @var string
	 */
	protected $surname = '';

	/**
	 * address
	 *
	 * @var string
	 */
	protected $address = '';

	/**
	 * telephone
	 *
	 * @var string
	 */
	protected $telephone = '';

	/**
	 * email
	 *
	 * @var string
	 */
	protected $email = '';

	/**
	 * message
	 *
	 * @var string
	 */
	protected $message = '';

	/**
	 * event
	 *
	 * @var \VJmedia\Vjeventdb3\Domain\Model\Event
	 */
	protected $event = NULL;
	
	
	/**
	 * @var string
	 * @validate \SJBR\SrFreecap\Validation\Validator\CaptchaValidator
	 */
	protected $captchaResponse;

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
	 * Returns the surname
	 *
	 * @return string $surname
	 */
	public function getSurname() {
		return $this->surname;
	}

	/**
	 * Sets the surname
	 *
	 * @param string $surname
	 * @return void
	 */
	public function setSurname($surname) {
		$this->surname = $surname;
	}

	/**
	 * Returns the address
	 *
	 * @return string $address
	 */
	public function getAddress() {
		return $this->address;
	}

	/**
	 * Sets the address
	 *
	 * @param string $address
	 * @return void
	 */
	public function setAddress($address) {
		$this->address = $address;
	}

	/**
	 * Returns the telephone
	 *
	 * @return string $telephone
	 */
	public function getTelephone() {
		return $this->telephone;
	}

	/**
	 * Sets the telephone
	 *
	 * @param string $telephone
	 * @return void
	 */
	public function setTelephone($telephone) {
		$this->telephone = $telephone;
	}

	/**
	 * Returns the email
	 *
	 * @return string $email
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * Sets the email
	 *
	 * @param string $email
	 * @return void
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * Returns the message
	 *
	 * @return string $message
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * Sets the message
	 *
	 * @param string $message
	 * @return void
	 */
	public function setMessage($message) {
		$this->message = $message;
	}

	/**
	 * Returns the event
	 *
	 * @return \VJmedia\Vjeventdb3\Domain\Model\Event $event
	 */
	public function getEvent() {
		return $this->event;
	}

	/**
	 * Sets the event
	 *
	 * @param \VJmedia\Vjeventdb3\Domain\Model\Event $event
	 * @return void
	 */
	public function setEvent(\VJmedia\Vjeventdb3\Domain\Model\Event $event) {
		$this->event = $event;
	}
	
	/**
	 * Sets the captchaResponse
	 *
	 * @param string $captchaResponse
	 * @return void
	 */
	public function setCaptchaResponse($captchaResponse) {
		$this->captchaResponse = $captchaResponse;
	}
	
	/**
	 * Getter for captchaResponse
	 *
	 * @return string
	 */
	public function getCaptchaResponse() {
		return $this->captchaResponse;
	}

}