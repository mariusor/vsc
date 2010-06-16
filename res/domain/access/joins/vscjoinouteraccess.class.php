<?php
/**
 * @package vsc_domain
 * @author marius orcsik <marius@habarnam.ro>
 * @date 10.06.02
 */
class vscJoinOuterAccess extends vscSqlJoinAccessA {
	public function getType () {
		return 'OUTER';
	}
}
