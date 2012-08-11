<?php

class vscRawHttpRequest extends vscRwHttpRequest {
	protected $aRawVars = array();

	public function __construct () {
		parent::__construct();

		if (isset ($_SERVER)) {
			$this->constructRawVars ();
		}
	}

	// this seems quite unsafe
	public function setRawVars ($aVars) {
		if (is_array($aVars)) {
			$this->aRawVars = array_merge ($aVars, $this->aRawVars);
		}
	}

	public function getRawVars () {
		return $this->aRawVars;
	}

	protected function getRawVar ($sVarName) {
		if (key_exists($sVarName, $this->aRawVars)) {
			return $this->aRawVars[$sVarName];
		} else {
			return null;
		}
	}

	public function getVars () {
		return array_merge ($this->aRawVars, parent::getVars());
	}

	public function getVar ($sVarName) {
		$mValue = parent::getVar($sVarName);
		if (!$mValue) {
			$mValue = urldecode($this->getRawVar($sVarName));
		}
		return $mValue;
	}

	/**
	 * @todo this has to be moved in the rw url handler
	 * @return void
	 */
	public function constructRawVars () {
		$sRawVars = file_get_contents('php://input');

		switch ($this->getContentType()) {
			case 'application/x-www-form-urlencoded':
				$aVars = explode('&',$sRawVars);
				foreach ($aVars as $sValue) {
					$key = substr($sValue, 0, stripos($sValue, '='));
					$value = substr($sValue, stripos($sValue, '=')+1);

					if (substr($key, -2, 2) == '[]') {
						$key = substr($key, 0, -2);
						if (key_exists($key, $this->aRawVars) && !is_array($this->aRawVars[$key])) {
							$this->aRawVars[$key] = array ($value);
						} else {
							$this->aRawVars[$key][] = $value;
						}
					} else {
						$this->aRawVars[$key] = $value;
					}
				}
				break;
			case 'application/json':
				$this->aRawVars = json_decode($sRawVars, true);
				break;
		}
	}
}