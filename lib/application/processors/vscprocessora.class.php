<?php
/**
 * @package vsc_application
 * @subpackage processors
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.31
 */
abstract class vscProcessorA implements vscProcessorI {
	protected $aLocalVars = array();

	/**
	 * @param array $aLocalVars
	 * @return void
	 */
	public function __construct ($aLocalVars = null) {
		$this->setLocalVars ($aLocalVars);

		$this->init ();
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
	 * @returns array
	 */
	public function getValueNames () {
		return $this->aLocalValueNames;
	}
}