<?php

namespace VJmedia\Vjeventdb3\Domain\ViewModel;

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
 * 
 * Represents an order for the order form.
 * 
 * @author Vincent Tietz
 *
 */
class EventOrder {
	
	/**
	 * @var string
	 */
	protected $name = "";
	
	/**
	 * @var string
	 */
	protected $surname = "";
	
	/**
	 * @var string
	 */
	protected $address = "";
	
	/**
	 * @var string
	 */
	protected $email = "";
	
	/**
	 * @var string
	 */
	protected $telephone = "";
	
	/**
	 * @var string
	 */
	protected $message = "";
	
	/**
	 * @var \VJmedia\Vjeventdb3\Domain\Model\Event
	 */
	protected $event = NULL;

	/**
	 * Constructor.
	 */
	public function __construct() {
	}
		
	public function setName($name) {
		$this->name = $name;
	}
	
	public function getName() {
		return $this->name;
	}

	public function setSurname($surname) {
		$this->surname = $surname;
	}
	
	public function getSurname() {
		return $this->surname;
	}
	
	public function setAddress($address) {
		$this->address = $address;
	}
	
	public function getAddress() {
		return $this->address;
	}
	
	public function setEmail($email) {
		$this->email = $email;
	}
	
	public function getEmail() {
		return $this->email;
	}	

	public function setMessage($message) {
		$this->message = $message;
	}
	
	public function getMessage() {
		return $this->message;
	}

	public function setEvent($event) {
		$this->event = $event;
	}
	
	public function getEvent() {
		return $this->event;
	}
	
}