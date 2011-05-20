<?php
/**
 * @package vsc_domain
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.06.02
 */
class vscJoinA extends vscObject {
	private	$oLeftField;
	private	$oRightLeft;

	public function getLeft() {
		return $this->oLeftField;
	}
	public function getRight() {
		return $this->oRightField;
	}

	/**
	 * initializing a JOIN clause
	 *
	 * @param vscFieldA $oLeftField
	 * @param vscFieldA $oRightField
	 */
	public function __construct (vscFieldA $oLeftField, vscFieldA $oRightField) {
		$this->oLeftField = $oLeftField;
		$this->oRightField = $oRightField;
	}

	public function getType () {
		return vscJoinType::INNER;
	}
}
