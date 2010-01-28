<?php
/**
 * interface for fields and indexes
 * @package ts_models
 * @author Marius Orcsik <marius@habarnam.ro>
 * @date 09.03.29
 */
interface fooFieldI {
	public function getType ();

	public function setName($sName);

	public function getName();

	/**
	 * returns the SQL definition of the entity
	 * @return string
	 */
	public function getDefinition ();
}