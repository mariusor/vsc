<?php
/**
 * @package vsc_domain
 * @subpackage domain
 * @author marius orcsik <marius@habarnam.ro>
 * @date 10.05.20
 */

interface vscCompositeDomainObjectI extends vscDomainObjectI {
	public function getDomainObjects ();
	public function getDomainObjectRelations ();
}