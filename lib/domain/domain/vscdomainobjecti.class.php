<?php
interface vscDomainObjectI {
	/**
	 * @param string $sAlias
	 * @return void
	 */
	public function setTableAlias ($sAlias);

	/**
	 * @return string
	 */
	public function getTableAlias ();

	/**
	 * @param string $sName
	 * @return void
	 */
	protected function setTableName ($sName);

	public function getTableName ();

	/**
	 * @param vscFieldA $oIndex
	 * @return void
	 */
	public function setPrimaryKey ();

	public function getPrimaryKey ();

	/**
	 * @param vscFieldA[] $aFields
	 * @param string $sAlias
	 * @return void
	 */
	private function addFields ($aFields, $sAlias);

	/**
	 * @param array $aIncField
	 * @return void
	 */
	private function addField ($aIncField);

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