<?php
/**
 * @package vsc_domain
 * @subpackage access
 * @author marius orcsik <marius@habarnam.ro>
 * @date 10.01.28
 */
interface vscSqlAccessI {
	static public function isValidConnection ($oConnection);

	public function save (vscDomainObjectI $oInc);

	public function insert (vscDomainObjectI $oInc);

	public function update (vscDomainObjectI $oInc);

	public function delete (vscDomainObjectI $oInc);
}