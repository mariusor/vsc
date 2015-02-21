<?php
/**
 * @package presentation
 * @subpackage requests
 * @author marius orcsik <marius@habarnam.ro>
 * @date 21.02.15
 */
namespace vsc\presentation\requests;

trait GetRequestT {
	protected $aGetVars = array();

	protected function initGet () {
		if (isset($_GET) && is_array($_GET)) {
			$this->aGetVars = $_GET;
		}
	}

	/**
	 * @return bool
	 */
	public function hasGetVars() {
		return (count($this->aGetVars) > 0);
	}

	/**
	 * @param string $sVarName
	 * @return bool
	 */
	public function hasGetVar($sVarName) {
		return array_key_exists($sVarName, $this->aGetVars);
	}

	/**
	 *
	 * @param string $sVarName
	 * @return mixed
	 */
	protected function getGetVar($sVarName) {
		if (array_key_exists($sVarName, $this->aGetVars)) {
			return $this->aGetVars[$sVarName];
		} else {
			return null;
		}
	}

	/**
	 * @return array
	 */
	public function getGetVars() {
		return $this->aGetVars;
	}
}
