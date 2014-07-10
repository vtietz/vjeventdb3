<?php

namespace VJmedia\Vjeventdb3\Domain\ViewModel;

use VJmedia\Vjeventdb3\Domain\ViewModel\SectionView;
use VJmedia\Vjeventdb3\Domain\ViewModel\DaySectionView;

class MonthSectionView extends SectionView {
	
	protected $days = array();
	
	public function addDay(\VJmedia\Vjeventdb3\Domain\ViewModel\DaySectionView $day) {
		$this->days[] = $day;
	}
	
	public function getDays() {
		return $this->days;
	}
	
}