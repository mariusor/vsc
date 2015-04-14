<?php
/**
 * @package presentation
 * @subpackage requests
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2011.08.11
 */
namespace vsc\presentation\requests;

class RawHttpRequest extends RwHttpRequest {
	protected $aRawVars = [];
	protected $sRawInput;

	public function __construct() {
		parent::__construct();

		if (isset ($_SERVER) && !$this->isGet()) {
			$this->constructRawVars();
		}
	}

	// this seems quite unsafe
	public function setRawVars($aVars) {
		if (is_array($aVars)) {
			if (is_array($this->aRawVars)) {
				$this->aRawVars = array_merge($aVars, $this->aRawVars);
			} else {
				$this->aRawVars = $aVars;
			}
		}
	}

	public function getRawVars() {
		if (!empty($this->aRawVars)) {
			return $this->aRawVars;
		}
		$sContentType = $this->getContentType();

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
			break;
		}
		if (!empty ($vars)) {
			$this->aRawVars = $vars;
		}
		return $this->aRawVars;
	}

	/**
	 * @param string $sVarName
	 */
	public function getRawVar($sVarName) {
		$aRawVars = $this->getRawVars();
		if (is_array($aRawVars) && array_key_exists($sVarName, $aRawVars)) {
			return self::getDecodedVar($aRawVars[$sVarName]);
		} else {
			return null;
		}
	}

	public function getVars() {
		$aRawVars = $this->getRawVars();
		$aParentVars = parent::getVars();
		if (!is_array($aRawVars)) {
			return parent::getVars();
		} else {
			if (is_array($aParentVars)) {
				return array_merge($aRawVars, $aParentVars);
			}
			return $aRawVars;
		}
	}

	public function hasVar($sVarName) {
		return (
			$this->hasRawVar($sVarName) ||
			parent::hasVar($sVarName)
		);
	}

	public function hasRawVar($sVarName) {
		$aRawVars = $this->getRawVars();
		return (is_array($aRawVars) && array_key_exists($sVarName, $aRawVars));
	}

	/**
	 * @param string $sVarName
	 */
	public function getVar($sVarName) {
		$mValue = parent::getVar($sVarName);
		if (!$mValue) {
			$mValue = $this->getRawVar($sVarName);
		}
		return $mValue;
	}

	/**
	 * @return string
	 */
	protected function getRawInput() {
		return file_get_contents('php://input');
	}

	/**
	 * @todo this has to be moved in the rw url handler
	 * @param string $sRawInput
	 * @return void
	 */
	protected function constructRawVars($sRawInput = null) {
		if (is_null($sRawInput)) {
			$this->sRawInput = $this->getRawInput();
		} else {
			$this->sRawInput = $sRawInput;
		}
		$this->aRawVars = null;
	}
}
