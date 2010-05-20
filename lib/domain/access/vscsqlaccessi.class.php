<?php
/**
 * @package vsc_domain
 * @subpackage access
 * @author marius orcsik <marius@habarnam.ro>
 * @date 10.01.28
 */
interface vscSqlAccessI {
	static public function isValidConnection ($oConnection);

	public function save ($oInc);

	public function create ($oInc);

	public function update ($oInc);

	public function delete ($oInc);
}