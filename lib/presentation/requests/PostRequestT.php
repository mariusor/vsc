<?php
/**
 * @package presentation
 * @subpackage requests
 * @author marius orcsik <marius@habarnam.ro>
 * @date 21.02.15
 */
namespace vsc\presentation\requests;


trait PostRequestT {
	protected $aPostVars = array();

	protected function initPost() {
		if (isset($_POST)) {
			$this->aPostVars = $_POST;
		}
	}

	/**
	 * @return bool
	 */
	public function hasPostVars() {
		return (count($this->aPostVars) > 0);
	}

	/**
	 * @param string $sVarName
	 * @return bool
	 */
	public function hasPostVar($sVarName) {
		return array_key_exists($sVarName, $this->aPostVars);
	}

	/**
	 *
	 * @param string $sVarName
	 * @return mixed
	 */
	protected function getPostVar($sVarName) {
		if (array_key_exists($sVarName, $this->aPostVars)) {
			return $this->aPostVars[$sVarName];
		} else {
			return null;
		}
	}

	/**
	 * @return array
	 */
	public function getPostVars() {
		return $this->aPostVars;
	}
}
