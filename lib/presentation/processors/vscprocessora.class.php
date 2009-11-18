<?php
/**
 * @package vsc_presentation
 * @subpackage processors
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.31
 */
abstract class vscProcessorA {
	protected $aLocalVars = array();

	public function __construct ($aLocalVars) {
		$this->setLocalVars ($aLocalVars);

		$this->init ();
	}

	public function setLocalVars ($aVars) {
		if (count($aVars) >= 1) {
			foreach ($this->aLocalVars as $sKey => $sValue) {
				$this->aLocalVars[$sKey] = array_shift($aVars);
			}
		}
	}

	public function getLocalVars () {
		return $this->aLocalVars;
	}

	public function getValueNames () {
		return $this->aLocalValueNames;
	}

	abstract public function init ();

	abstract public function handleRequest (vscHttpRequestA $oHttpRequest);
}