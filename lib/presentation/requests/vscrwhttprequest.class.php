<?php
/**
 * @package vsc_presentation
 * @subpackage requests
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.07.13
 */
import ('coreexceptions');
class vscRwHttpRequest extends vscHttpRequestA {
	protected $aTaintedVars;

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
		$this->aTaintedVars = $aVars;
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
			$this->getRequestUri();
			$this->constructTaintedVars ();
		}
	}

	public function getTaintedVars () {
		return $this->aTaintedVars;
	}

	protected function getTaintedVar ($sVarName) {
		if (key_exists($sVarName, $this->aTaintedVars))
			return $this->aTaintedVars[$sVarName];
		else throw new vscException ('No URL variable named: ' . $sVarName);
	}

	public function getVar ($sVarName) {
		try {
			return parent::getVar($sVarName);
		} catch (vscException $e) {
			try {
				return urldecode($this->getTaintedVar($sVarName));
			} catch (vscException $e) {
				throw new vscException ('Variable ' . $sVarName . ' doesn\'t exist in the HTTP request or in the URL.');
			}
		}
	}

	/**
	 * @todo this has to be moved in the rw url handler
	 * @return void
	 */
	public function constructTaintedVars () {
		foreach(explode ('/', $this->getRequestUri()) as $iKey => $sUrlId) {
			if ($sUrlId) {
				$t = explode (':', $sUrlId);
				if (count($t) > 1) {
					$this->aTaintedVars[array_shift($t)] = implode(':', $t);
				} else {
					$this->aTaintedVars[] = $t[0];
				}
			}
		}
	}
}