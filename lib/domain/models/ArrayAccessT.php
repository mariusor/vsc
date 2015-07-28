<?php
/**
 * @package domain
 * @subpackage models
 * @author Marius Orcsik <marius@habarnam.ro>
 * @created 2015-04-15
 */
namespace vsc\domain\models;

trait ArrayAccessT
{
	/**
	 * @param string $sOffset
	 * @param mixed $mValue
	 * @return mixed
	 */
	public abstract function __set($sOffset, $mValue);

	/**
	 * @param string $sOffset
	 * @return mixed
	 */
	public abstract function __get($sOffset);

	/**
	 * @return array
	 */
	private function getPropertyNames() {
		$ret = [];
		$mirror = new \ReflectionClass($this);
		foreach ($mirror->getProperties() as $mirrorProperty) {
			$ret[] = $mirrorProperty->getName();
		}

		return $ret;
	}

	/**
	 * ArrayAccess interface
	 * @param mixed $sOffset
	 * @param mixed $mValue
	 * @throws
	 */
	public function offsetSet($sOffset, $mValue)
	{
		$this->__set($sOffset, $mValue);
	}

	/**
	 * @param string $sOffset
	 * @return bool
	 */
	public function offsetExists($sOffset)
	{
		return in_array($sOffset, $this->getPropertyNames());
	}

	/**
	 * @param string $sOffset
	 */
	public function offsetUnset($sOffset)
	{
		$oProperty = new \ReflectionProperty($this, $sOffset);
		if ($oProperty->isPublic()) {
			unset ($this->$sOffset);
		}
	}

	/**
	 * @param string $sOffset
	 * @return mixed
	 */
	public function offsetGet($sOffset)
	{
		return $this->__get($sOffset);
	}

}
