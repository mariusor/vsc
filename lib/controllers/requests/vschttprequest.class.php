<?php

class vscHttpRequest {
	private $sHttpMethod = null;
	private $aGetVars = array();
	private $aPostVars = array();
	private $aCookieVars = array();
	private $aTaintedVars = array();

	private $aVarOrder;

	public function __construct () {
		$this->aGetVars = $_GET;
		$this->aPostVars = $_POST;
		$this->aCookieVars = $_COOKIE;

		$this->getHttpMethod();
	}

	public function getVarOrder () {
		if (count($this->aVarOrder) != 4){
			// get gpc order
			$sOrder = ini_get('variables_order');
			for ($i = 0; $i < 4; $i++) {
				// reversing the order
				$this->aVarOrder[$i] = substr($sOrder, $i, 1);
			}
		}
		return $this->aVarOrder;
	}

	public function getVar ($sVarName) {
		foreach ($this->getVarOrder() as $sMethod) {
			try {
				switch ($sMethod) {
					case 'G':
						return $this->getGetVar($sVarName);
						break;
					case 'P':
						return $this->getPostVar($sVarName);
						break;
					case 'C':
						return $this->getCookieVar($sVarName);
						break;
					case 'S':
	//					return $this->getSeesionVar($sVarName);
						break;
				}
			} catch (vscException $e) {
				// no var - go on
			}
		}
		throw new vscException ('Variable ' . $sVarName . ' doesn\'t exist in the http request.');
	}
	public function getGetVar ($sVarName) {
		if (key_exists($sVarName, $this->aGetVars))
			return $this->aGetVars[$sVarName];
		else throw new vscException ('No GET var named: ' . $sVarName);
	}
	public function getPostVar ($sVarName) {
		if (key_exists($sVarName, $this->aPostVars))
			return $this->aPostVars[$sVarName];
		else throw new vscException ('No POST var named: ' . $sVarName);
	}
	public function getCookieVar ($sVarName) {
		if (key_exists($sVarName, $this->aCookieVars))
			return $this->aCookieVars[$sVarName];
		else throw new vscException ('No COOKIE var named: ' . $sVarName);
	}
	public function getTaintedVar ($sVarName) {
		// TODO
	}

	public function setCookieVar ($sVarName, $sVarValue) {
		// TODO
	}

	public function getHttpMethod () {
		if (!$this->sHttpMethod) {
			$this->sHttpMethod = $_SERVER['REQUEST_METHOD'];
		}
		return $this->sHttpMethod;
	}
}