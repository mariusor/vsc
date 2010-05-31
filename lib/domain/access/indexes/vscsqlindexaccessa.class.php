<?php
/**
 * @package vsc_domain
 * @subpackage access
 * @author marius orcsik <marius@habarnam.ro>
 * @date 10.05.29
 */
abstract class vscSqlIndexAccessA extends vscObject {
	private $oConnection;

	public function setConnection (vscSqlDriverA $oConnection) {
		$this->oConnection = $oConnection;
	}

	public function getConnection () {
		return $this->oConnection;
	}
	abstract public function getType(vscIndexA $oIndex);
}