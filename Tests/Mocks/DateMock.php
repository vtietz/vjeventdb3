<?php

namespace VJmedia\Vjeventdb3\Tests\Mocks;

use VJmedia\Vjeventdb3\Domain\Model\Date;

class DateMock {
	
	/**
	 * @var \VJmedia\Vjeventdb3\Tests\Mocks\DateMock The mock object.
	 */
	protected $dateMock = NULL;

	public function __construct() {
		$this->dateMock = new \VJmedia\Vjeventdb3\Domain\Model\Date();
	}
	
	/**
	 * @param DateTime $startDate start date.
	 * @return \VJmedia\Vjeventdb3\Tests\Mocks\DateMock
	 */
	public function withStartDate($startDate) {
		$this->dateMock->setStartDate($startDate);
		return $this;
	}

	/**
	 * @param DateTime $endDate end date.
	 * @return \VJmedia\Vjeventdb3\Tests\Mocks\DateMock
	 */
	public function withEndDate($endDate) {
		$this->dateMock->setEndDate($endDate);
		return $this;
	}

	/**
	 * @param integer $startTime start time.
	 * @return \VJmedia\Vjeventdb3\Tests\Mocks\DateMock
	 */
	public function withStartTime($startTime) {
		$this->dateMock->setStartTime($startTime);
		return $this;
	}
	
	/**
	 * @param integer $frequency The frequency.
	 * @return \VJmedia\Vjeventdb3\Tests\Mocks\DateMock
	 */
	public function withFrequencey($frequency) {
		$this->dateMock->setFrequency($frequency);
		return $this;
	}
	
	/**
	 * @param integer $endTime end time.
	 * @return \VJmedia\Vjeventdb3\Tests\Mocks\DateMock
	 */
	public function withEndTime($endTime) {
		$this->dateMock->setEndTime($endTime);
		return $this;
	}
		
	public function build() {
		return $this->dateMock;
	}
	
	/**
	 * Produces a date object.
	 * @param \DateTime $startDate The start date.
	 * @param integer $startTime The start time.
	 * @param \DateTime $endDate The end date.
	 * @param integer $endTime The end time.
	 * @param integer $frequency The frequency.
	 */
	public static function getDateMock($startDate, $startTime, $endDate, $endTime, $frequency) {
		$dateMock = new \VJmedia\Vjeventdb3\Tests\Mocks\DateMock();
		return $dateMock->
		withStartDate($startDate)->
		withStartTime($startTime)->
		withEndDate($endDate)->
		withEndTime($endTime)->
		withFrequencey($frequency)->
		build();
	}
	
}