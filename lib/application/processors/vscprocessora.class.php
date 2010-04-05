<?php
/**
 * @package vsc_application
 * @subpackage processors
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.31
 */
abstract class vscProcessorA extends vscObject implements vscProcessorI {
	private $oCurrentMap;
	protected $aLocalVars = array();

	/**
	 * @param array $aLocalVars
	 * @return void
	 */
	public function __construct () {
		import ('infrastructure');
		$this->setLocalVars (vsc::getHttpRequest()->getTaintedVars());

		$this->init ();
	}

	/**
	 * @return vscMapping
	 */
	public function getMap () {
		if ($this->oCurrentMap instanceof vscMapping) {
			return $this->oCurrentMap;
		} else {
			throw new vscExceptionView ('Make sure the current map is correctly set.');
		}
	}

	public function setMap ($oMap) {
		$this->oCurrentMap = $oMap;
	}

	/**
	 *
	 * @param array $aVars
	 * @return void
	 */
	public function setLocalVars ($aVars = null) {
		if (count($aVars) >= 1) {
			foreach ($this->aLocalVars as $sKey => $sValue) {
				$this->aLocalVars[$sKey] = array_shift($aVars);
			}
		}
	}

	/**
	 * @return array
	 */
	public function getLocalVars () {
		return $this->aLocalVars;
	}

	/**
	 * @param string $sVar
	 * @param string $sValue
	 */
	public function setVar ($sVar, $sValue) {
		if (key_exists ($sVar, $this->aLocalVars)) {
			$this->aLocalVars[$sVar] = $sValue;
		}
	}

	/**
	 * @param string $sVar
	 */
	public function getVar ($sVar) {
		if (key_exists ($sVar, $this->aLocalVars)) {
			return $this->aLocalVars[$sVar];
		} else {
			return null;
		}
	}

	/**
	 * @returns array
	 */
	public function getValueNames () {
		return $this->aLocalValueNames;
	}
}
