<?php
/**
 * @package vsc_presentation
 * @subpackage requests
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.07.13
 */
class vscRwHttpRequest extends vscHttpRequestA {
	private $sRequestUri		= null;
	private $aTaintedVars		= array();

	/**
	 * returns the key of the first url parameter
	 * @return string
	 */
	public function getFirstParameter() {
		$aKeys = array_keys($this->aTaintedVars);
		return array_shift($aKeys);
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
				return $this->getTaintedVar($sVarName);
			} catch (vscException $e) {
				throw new vscException ('Variable ' . $sVarName . ' doesn\'t exist in the HTTP request or in the URL.');
			}
		}
	}

	/**
	 * Returns the REQUEST_URI which is used to get the URL Rewrite variables
	 * This will also remove the part of the path that is actually an existing path
	 * lighttpd:
	 *  url.rewrite = (
	 * 		"^/([^?]*)?(.*)$" => "/index.php$2"
 	 *  )
	 *
	 * @todo move to the vscUrlRWParser
	 * @return string
	 */
	public function getRequestUri () {
		if (!$this->sRequestUri) {
			$sServerType = $_SERVER['SERVER_SOFTWARE'];

			// this header is present for all servers in the same form
			$sCurrentScriptDir = dirname ($_SERVER['PHP_SELF']) != '/' ? dirname ($_SERVER['PHP_SELF']) : '';
			if (stristr($sServerType, 'lighttpd')) {
				$sReqUri = $_SERVER['REQUEST_URI'];
				$this->sRequestUri = str_replace ($sCurrentScriptDir, '', $sReqUri);
			} elseif (stristr($sServerType, 'apache')) {
				$sReqUri = $_SERVER['REQUEST_URI'];
				$this->sRequestUri = str_replace ($sCurrentScriptDir, '', $sReqUri);
			} elseif (stristr($sServerType, 'cherokee')) {
				// TODO
			}

			// removing unnecessary get vars
			$iQMarkPos = strpos ($this->sRequestUri, '?');
			if ($iQMarkPos) {
				$this->sRequestUri = substr ($this->sRequestUri, 0, $iQMarkPos);
			}
		}
		return $this->sRequestUri;
	}

	/**
	 * @todo this has to be moved in the rw url handler
	 * @return void
	 */
	public function constructTaintedVars () {
		foreach(explode ('/', $this->getRequestUri()) as $sUrlId) {
			if ($sUrlId) {
				$t = explode (':', $sUrlId);
				if (count($t) > 1) {
					$this->aTaintedVars[array_shift($t)] = implode(':', $t);
				} else {
					$this->aTaintedVars[$t[0]] = '';
				}
			}
		}
	}
}