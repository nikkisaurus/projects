<?php

class Raid {
	public $abbreviated;
	public $abbreviated_proper;
	public $improper;
	public $proper;

	public function __construct($abbreviated, $abbreviated_proper, $improper, $proper) {
		$this->abbreviated = $abbreviated;
		$this->improper = $improper;
		$this->proper = $proper;
		$this->abbreviated_proper = $abbreviated_proper;
	}

	public function abbreviated() {
		return $this->abbreviated;
	}

	public function abbreviated_proper() {
		return $this->abbreviated_proper;
	}

	public function improper() {
		return $this->improper;
	}

	public function proper() {
		return $this->proper;
	}

	public static function validate($raid) {
		$valid_raids = array('ds', 'fl', 'soo', 't11', 't14', 'tot', 'uld');

		if (in_array($raid, $valid_raids)) {
			global $$raid;
			return $$raid;
		}
	}
}
