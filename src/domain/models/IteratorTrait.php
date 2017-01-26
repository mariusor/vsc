<?php
/**
 * @package domain
 * @subpackage models
 * @author Marius Orcsik <marius@habarnam.ro>
 * @created 2015-04-15
 */
namespace vsc\domain\models;

trait IteratorTrait {
	/**
	 * @var string
	 */
	protected $_current;

	/**
	 * @param string $sKey
	 * @return bool
	 */
	abstract public function offsetExists($sKey);

	/**
	 * @param string $sOffset
	 */
	protected function setCurrent($sOffset) {
		if ($this->offsetExists($sOffset))
			$this->_current = $sOffset;
	}

	/**
	 * @return string
	 */
	protected function getCurrent() {
		return $this->_current;
	}


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
	 * @return int
	 */
	public abstract function count();

	/**
	 * @return array
	 */
	private function getPropertyNames() {
		$ret = [];
		$mirror = new \ReflectionClass($this);
		foreach ($mirror->getProperties() as $mirrorProperty) {
			$name = $mirrorProperty->getName();
			if ($name == '_current') continue;
			$ret[] = $name;
		}

		return $ret;
	}

	/**
	 * Iterator interface
	 * @return mixed
	 */
	public function current()
	{
		if (is_null($this->_current)) {
			$this->rewind();
		}
		return $this->__get($this->_current);
	}

	/**
	 * @return string
	 */
	public function key()
	{
		if (is_null($this->_current)) {
			$this->rewind();
		}
		return $this->_current;
	}

	/**
	 * @return void
	 */
	public function next()
	{
		$aKeys = $this->getPropertyNames();

		$iCurrent = array_search($this->_current, $aKeys);

		if ($iCurrent + 1 < $this->count()) {
			$this->_current = $aKeys[$iCurrent + 1];
		} else {
			$this->_current = null;
		}
	}

	/**
	 * @return void
	 */
	public function rewind()
	{
		$aKeys = $this->getPropertyNames();

		if (is_array($aKeys) && isset($aKeys[0])) {
			$this->_current = $aKeys[0];
		}
	}

	/**
	 * @return bool
	 */
	public function valid()
	{
		$aKeys = $this->getPropertyNames();

		if (in_array($this->_current, $aKeys)) {
			return true;
		}

		return false;
	}
}
