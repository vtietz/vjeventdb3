<?php
namespace VJmedia\Vjeventdb3\Domain\ViewModel;

use VJmedia\Vjeventdb3\Domain\ViewModel\SectionView;

class DaySectionView extends SectionView {
	
	protected $dates = NULL;

	public function addDate(\VJmedia\Vjeventdb3\Domain\Model\Date $date) {
		$this->dates[] = $date;
	}

	public function getDates() {
		return $this->dates;
	}
	
	
}