<?php
/**
 * @package presentation
 * @subpackage requests
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2011.08.11
 */
namespace vsc\presentation\requests;

class RawHttpRequest extends RwHttpRequest {
	protected $aRawVars = array();
	protected $sRawInput;

	public function __construct () {
		parent::__construct();

		if (isset ($_SERVER) && !$this->isGet()) {
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
		if (!empty($this->aRawVars)) {
			return $this->aRawVars;
		}
		$sContentType = $this->getContentType();

		if (empty($sContentType)) {
			throw new ExceptionRequest('Can not process a request with an empty content-type');
		}

		$vars = array();
		switch ($sContentType) {
			case 'application/x-www-form-urlencoded':
				parse_str($this->sRawInput, $vars);
				break;
			case 'application/json':
				$vars = json_decode($this->sRawInput, true);
				break;
			case 'application/xml':
			default:
				throw new ExceptionRequest('This content-type [' . $sContentType . '] is not supported');
				break;
		}
		if (!empty ($vars)) {
			$this->aRawVars = $vars;
		}
		return $this->aRawVars;
	}

	public function getRawVar ($sVarName) {
		$aRawVars = $this->getRawVars();
		if (array_key_exists($sVarName, $aRawVars)) {
			return self::getDecodedVar($aRawVars[$sVarName]);
		} else {
			return null;
		}
	}

	public function getVars () {
		return array_merge ($this->getRawVars(), parent::getVars());
	}

	public function hasVar($sVarName) {
		return (
			$this->hasRawVar($sVarName) ||
			parent::hasVar($sVarName)
		);
	}

	public function hasRawVar ($sVarName) {
		$aRawVars = $this->getRawVars();
		return (is_array($aRawVars) && array_key_exists($sVarName, $aRawVars));
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
	 * @throws ExceptionRequest
	 * @return void
	 */
	protected function constructRawVars ($sRawInput = null) {
		if (is_null($sRawInput)) {
			$this->sRawInput = file_get_contents('php://input');
		} else {
			$this->sRawInput = $sRawInput;
		}
		$this->aRawVars = null;
	}
}
