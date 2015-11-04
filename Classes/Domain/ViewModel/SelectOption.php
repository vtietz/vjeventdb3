<?php
namespace VJmedia\Vjeventdb3\Domain\ViewModel;

class SelectOption {
	
	protected $uid = NULL;
	
	protected $label = NULL;
	
	function __construct ($uid, $label) {
		$this->uid = $uid;
		$this->label = $label;
	}
	
	public function getUid() {
		return $this->uid;
	}

	public function getLabel() {
		return $this->label;
	}
	
}