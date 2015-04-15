<?php
/**
 * @package domain
 * @subpackage models
 * @author Marius Orcsik <marius@habarnam.ro>
 * @created 2015-04-15
 */
namespace vsc\domain\models;

trait CountableT
{
	/**
	 * @return int
	 */
	public function count()
	{
		$mirror = new \ReflectionClass($this);
		return count($mirror->getProperties(\ReflectionProperty::IS_PUBLIC));
	}
}
