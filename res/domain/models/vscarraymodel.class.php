<?php
/**
 * @package vsc_domain
 * @subpackage models
 * @author marius orcsik <marius@habarnam.ro>
 * @date 10.04.15
 */

import ('domain/models');
class vscArrayModel extends vscModelA {
	protected $aContent = array();

	public function __construct ($aIncArray = array()) {
		$this->aContent = $aIncArray;

		parent::__construct();
	}

	public function __get ($sIncName) {
		if (isset($this->aContent[$sIncName]))
			return $this->aContent[$sIncName];
		parent::__get ($sIncName);
	}

	public function __set($sIncName, $value) {
		if (isset($this->aContent[$sIncName])) {
			$this->aContent[$sIncName] = $value;
			return;
		}
		parent::__set ($sIncName, $value);
	}

	public function toArray () {
		return $this->aContent;
	}
}