<?php
/**
 * @package vsc_presentation
 * @subpackage helpers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 13.01.02
 */

class vscViewHelperA extends vscNullA /* implements vscViewI  */ {
	private $sName;

	/**
	 * @var vscModelA
	 */
	private $oModel;

	/**
	 * @var vscViewA
	 */
	private $oView;

	/**
	 * @param vscViewA $oView
	 * @return void
	 */
	public function setView (vscViewA $oView) {
		$this->oView = $oView;
	}

	/**
	 * @return vscViewA
	 */
	public function getView () {
		return $this->oView;
	}

	/**
	 * @param vscModelA $oModel
	 * @return void
	 */
	public function setModel (vscModelA $oModel) {
		$this->oModel = $oModel;
	}

	/**
	 * @return vscModelA
	 */
	public function getModel () {
		return $this->$oModel;
	}
}