<?php
/**
 * @package vsc_domain
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.06.02
 */
class vscJoinInnerAccess  extends vscSqlJoinAccessA {
	public function getType () {
		return 'INNER';
	}
}
