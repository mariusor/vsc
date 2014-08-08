<?php
/**
 * @package presentation
 * @subpackage requests
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.07.13
 */
namespace vsc\presentation\requests;

// \vsc\import ('exceptions');
class RwHttpRequest extends HttpRequestA {
	protected $aTaintedVars = array();

	/**
	 * returns the key of the first url parameter
	 * @return string
	 */
	public function getFirstParameter() {
		$aKeys = array_keys($this->aTaintedVars);
		return array_shift($aKeys);
	}

	// this seems quite unsafe
	public function setTaintedVars ($aVars) {
		if (is_array($aVars)) {
			$this->aTaintedVars = array_merge ($aVars, $this->aTaintedVars);
		}
	}

	/**
	 * returns the key of the last url parameter
	 * @return string
	 */
	public function getLastParameter() {
		$aKeys = array_keys($this->aTaintedVars);
		return array_pop ($aKeys);
	}

	public function __construct () {
		parent::__construct();
		if (isset ($_SERVER)) {
			$this->getUri();
			$this->constructTaintedVars ();
		}
	}

	public function getTaintedVars () {
		return $this->aTaintedVars;
	}

	protected function getTaintedVar ($sVarName) {
		if (array_key_exists($sVarName, $this->aTaintedVars)) {
			return self::getDecodedVar($this->aTaintedVars[$sVarName]);
		} else {
			return null;
		}
	}

	public function getVars () {
		return array_merge ($this->aTaintedVars, parent::getVars());
	}

	public function getVar ($sVarName) {
		$mValue = parent::getVar($sVarName);
		if (!$mValue) {
			$mValue = $this->getTaintedVar($sVarName);
		}
		return $mValue;
	}

	/**
	 * @todo this has to be moved in the rw url handler
	 * @return void
	 */
	public function constructTaintedVars () {
		foreach(explode ('/', $this->getUri()) as $iKey => $sUrlId) {
			if ($sUrlId) {
				$t = explode (':', $sUrlId);
				if (count($t) > 1) {
					$this->aTaintedVars[array_shift($t)] = implode(':', $t);
				} /*else {
					$this->aTaintedVars[] = $t[0];
				}*/
			}
		}
	}
}
