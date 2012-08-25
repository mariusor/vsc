<?php
import ('presentation');
import ('requests');
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
			return self::getDecodedVar($this->aRawVars[$sVarName]);
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
			$mValue = $this->getRawVar($sVarName);
		}
		return $mValue;
	}

	/**
	 * @todo this has to be moved in the rw url handler
	 * @return void
	 */
	public function constructRawVars () {
		$sRawVars = file_get_contents('php://input');

		$sContentType = $this->getContentType();

		if (empty ($sContentType)) return;

		$vars = array();
		switch ($sContentType) {
			case 'application/x-www-form-urlencoded':
				parse_str($sRawVars, $vars);
				break;
			case 'application/json':
				$vars = json_decode($sRawVars, true);
				break;
			case 'application/xml':
			default:
				throw new vscExceptionRequest('This content-type ['.$sContentType.'] is not yet supported');
				break;
		}
		if (!empty ($vars)) {
			$this->aRawVars = $vars;
		}
	}
}