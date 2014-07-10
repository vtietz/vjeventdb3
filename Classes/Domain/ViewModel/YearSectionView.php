<?php

namespace VJmedia\Vjeventdb3\Domain\ViewModel;

use VJmedia\Vjeventdb3\Domain\ViewModel\SectionView;
use VJmedia\Vjeventdb3\Domain\ViewModel\MonthSectionView;

class YearSectionView extends SectionView {
	
	protected $months = array();
	
	public function addMonth(\VJmedia\Vjeventdb3\Domain\ViewModel\MonthSectionView $month) {
		$this->months[] = $month;
	}
	
	public function getMonths() {
		return $this->months;
	}
	
}