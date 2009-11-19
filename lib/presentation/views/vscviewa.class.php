<?php
/**
 * @package vsc_presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.30
 */
abstract class vscViewA implements vscViewI {
	private $oModel;
	private $sOutput;

	public function setOutput ($sText) {
		$this->sOutput = $sText;
	}

	public function getOutput () {
		return $this->sOutput;
	}
}
