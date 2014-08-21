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
		return $this->aRawVars;
	}

	protected function getRawVar ($sVarName) {
		if (array_key_exists($sVarName, $this->aRawVars)) {
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
	 * @throws ExceptionRequest
	 * @return void
	 */
	public function constructRawVars ($sRawInput = null) {
		if (is_null($sRawInput)) {
			$sRawInput = file_get_contents('php://input');
		}
		$sContentType = $this->getContentType();

		if (empty ($sContentType)) return;

		$vars = array();
		switch ($sContentType) {
			case 'application/x-www-form-urlencoded':
				parse_str($sRawInput, $vars);
				break;
			case 'application/json':
				$vars = json_decode($sRawInput, true);
				break;
			case 'application/xml':
			default:
				throw new ExceptionRequest('This content-type ['.$sContentType.'] is not yet supported as an input type');
				break;
		}
		if (!empty ($vars)) {
			$this->aRawVars = $vars;
		}
	}
}
