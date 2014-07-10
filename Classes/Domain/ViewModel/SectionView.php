<?php

namespace VJmedia\Vjeventdb3\Domain\ViewModel;

class SectionView {
	
	protected $date = 0;
	
	public function setDate($date) {
		$this->date = $date;
	}
	
	public function getDate() {
		return $this->date;
	}
	
}