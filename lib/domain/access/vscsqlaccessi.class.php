<?php
/**
 * @package vsc_domain
 * @subpackage access
 * @author marius orcsik <marius@habarnam.ro>
 * @date 10.01.28
 */
interface vscSqlAccessI {

	static public function isValidConnection ($oConnection);

	public function save (vscDomainObjectA $oInc);

	public function insert (vscDomainObjectA $oInc);

	public function update (vscDomainObjectA $oInc);

	public function delete (vscDomainObjectA $oInc);
}