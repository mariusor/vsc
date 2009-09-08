<?php
/**
 * @package vsc_presentation
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.31
 */
abstract class vscControllerA {
	private $aLocalVars;

	public function __construct ($aLocalVars) {
		$this->setLocalVars ($aLocalVars);

		$this->init ();
	}

	public function setLocalVars ($aVars) {
		if (count($aVars) >= 1) {
			$this->aLocalVars = $aVars;
		}
	}

	public function getLocalVars () {
		return $this->aLocalVars;
	}

	abstract public function init ();

	abstract public function handleRequest (vscHttpRequestA $oHttpRequest);
}