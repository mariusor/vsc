<?php
/**
 * @package vsc_domain
 * @subpackage domain
 * @author marius orcsik <marius@habarnam.ro>
 * @date 10.01.28
 */

interface vscDomainObjectI {
	/**
	 * @param vscFieldA[] $aFields
	 * @param string $sAlias
	 * @return void
	 */
	public function addFields ($aFields, $sAlias);

	/**
	 * @param array $aIncField
	 * @return void
	 */
	public function addField ($aIncField);

	/**
	 * @return vscFieldA[]
	 */
	public function getFields ();

	/**
	 * gets all the column names as an array
	 * @return string[]
	 */
	public function getFieldNames ($bWithAlias = false);

	public function addIndex (vscIndexA $oIndex);

	public function getIndexes ($bWithPrimaryKey = false);
}
