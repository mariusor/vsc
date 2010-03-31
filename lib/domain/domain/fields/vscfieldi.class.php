<?php
/**
 * interface for fields and indexes
 * @package vsc_domain
 * @subpackage domain
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.03.29
 */
interface vscFieldI {
	public function getType ();

	public function setName($sName);

	public function getName();

	/**
	 * returns the SQL definition of the entity
	 * @return string
	 */
	public function getDefinition ();
}