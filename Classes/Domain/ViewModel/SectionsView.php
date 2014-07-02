<?php
namespace VJmedia\Vjeventdb3\Domain\ViewModel;

class SectionsView {
	
	/**
	 * @var string The section title.
	 */
	protected $sectionTitle = "";

	/**
	 * @var array The events in the section from type \VJmedia\Vjeventdb3\Domain\ViewModel\EventsView. 
	 */
	protected $eventsViews = array();
	
	public function setSectionTitle($sectionTitle) {
		$this->sectionTitle = $sectionTitle;
	}
	
	public function getSectionTitle() {
		return $this->sectionTitle;
	}
	
	public function addEventsView($eventsView)  {
		$this->eventsViews[] = $eventsView;
	}
	
	public function getEventsViews() {
		return $this->eventsViews;
	}
	
}