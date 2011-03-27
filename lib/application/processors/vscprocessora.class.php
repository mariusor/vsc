<?php
/**
 * @package vsc_application
 * @subpackage processors
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.31
 */
import ('presentation/views');
abstract class vscProcessorA extends vscObject implements vscProcessorI {
	private $oCurrentMap;
	protected $aLocalVars = array();

	/**
	 * @return vscProcessorMap
	 */
	public function getMap () {
		if ($this->oCurrentMap instanceof vscMappingA) {
			return $this->oCurrentMap;
		} else {
			throw new vscExceptionView ('Make sure the current map is correctly set.');
		}
	}

	/**
	 * @param vscMappingA $oMap
	 */
	public function setMap (vscMappingA $oMap) {
		$this->oCurrentMap = $oMap;
		$aTainted = $oMap->getTaintedVars();
		if (is_array($aTainted) && count ($aTainted) >= 1) {
			$this->setLocalVars($aTainted);
		}
	}

	/**
	 *
	 * @param array $aVars
	 * @return void
	 */
	public function setLocalVars ($aVars = array()) {
		foreach ($this->aLocalVars as $sKey => $sValue) {
			$this->aLocalVars[$sKey] = array_shift($aVars);
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
