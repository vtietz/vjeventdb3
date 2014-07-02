<?php
namespace VJmedia\Vjeventdb3\Domain\ViewModel;

class EventsView {

	/**
	 * @var \VJmedia\Vjeventdb3\Domain\Model\Event
	 */
	protected $event = NULL;
	
	/**
	 * @var \VJmedia\Vjeventdb3\Domain\Model\Date
	 */
	protected $date = NULL;
	
	/**
	 * @var integer
	 */
	protected $starttime = 0;

	/**
	 * @var integer
	 */
	protected $endtime = 0;
	
	/**
	 * @var integer
	 */
	protected $duration = 0;
	
	
} 