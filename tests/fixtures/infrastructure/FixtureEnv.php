<?php
/**
 * Created by PhpStorm.
 * User: habarnam
 * Date: 9/5/14
 * Time: 10:35 PM
 */

namespace fixtures\infrastructure;


use vsc\infrastructure\vsc;

class FixtureEnv extends vsc {
	private $isDevelopmentEnviroment = false;
	private $isCli = false;

	public function setIsDevelopment ($isDevelopment) {
		$this->isDevelopmentEnviroment = $isDevelopment;
	}

	/**
	 * @return boolean
	 */
	public function isDevelopment () {
		return $this->isDevelopmentEnviroment;
	}

	public function setIsCli ($IsIt) {
		$this->isCli = $IsIt;
	}

	protected function _isCli () {
		return $this->isCli;
	}
} 
