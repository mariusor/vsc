<?php
/**
 * @package vsc_domain
 * @subpackage domain
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.01.28
 */

interface vscDomainObjectI {
	public function getFields();

	/**
	 * gets all the column names as an array
	 * @return string[]
	 */
	public function getFieldNames ($bWithAlias = false);


	public function getIndexes ($bWithPrimaryKey = false);
}
