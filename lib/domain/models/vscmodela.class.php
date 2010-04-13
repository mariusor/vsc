<?php
/**
 * @package vsc_domain
 * @subpackage models
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.11.19
 */
abstract class vscModelA extends vscNull implements vscModelI {
	private $sOffset;

	// ArrayAccess interface
	public function offsetSet($offset, $value) {
		$this->__set($offset, $value);
	}
	public function offsetExists($offset) {
		return isset($this->$offset);
	}
	public function offsetUnset($offset) {
		if (!$oProperty->isPrivate()) {
			unset ($this->$offset);
		}
	}

	public function offsetGet($offset) {
		return $this->__get($offset);
	}

	// Iterator interface
	public function current  () {
		return $this->offsetGet($this->sOffset);
	}

	public function key () {
		return $this->sOffset;
	}

	public function next () {
		$aProperties = $this->getProperties();
		$aKeys = array_keys ($aProperties);

		$iCurrent = array_search($this->sOffset, $aKeys);

		if ($iCurrent+1 < $this->count()) {
			$this->sOffset = $aKeys[$iCurrent+1];
		} else {
			$this->sOffset = null;
		}
	}

	public function rewind () {
		$aProperties = $this->getProperties();
		$aKeys = array_keys ($aProperties);

		if (is_array($aKeys) && isset ($aKeys[0]))
			$this->sOffset = $aKeys[0];
	}

	public function valid () {
		$oRObject = new ReflectionObject ($this);
		return ($oRObject->hasProperty($this->sOffset) && $oRObject->getProperty($this->sOffset)->isPublic());
	}

	// Countable interface
	public function count () {
		return count ($this->getProperties());
	}

	public function __get ($sIncName) {
		try {
			$oProperty = new ReflectionProperty($this, $sIncName);
			if (!$oProperty->isPublic()) {
				// try for a getter method
				$sGetterName = 'get'.ucfirst($sIncName);
				$oGetter = new ReflectionMethod($this, $sGetterName);

				$this->sOffset = $sIncName; // ?? I wonder if setting the offset to the current read position is the right way
				return $oGetter->invoke($this, $sIncName);
			} else {
				$this->sOffset = $sIncName; // ?? I wonder if setting the offset to the current read position is the right way
				return $oProperty->getValue($this);
			}
		} catch (ReflectionException $e) {
//			$this->sOffset = $sIncName;
//			return $this->$sIncName;
		}
//		d ($sIncName, $oProperty, $oProperty->getValue($this));
		parent::__get ($sIncName);
	}

	public function __set($sIncName, $value) {
		if (is_null($sIncName)) {
			throw ReflectionError ('Can\'t set a value to a null property on the current object ['. get_class ($this).']');
		}
		try {
			$oProperty = new ReflectionProperty($this, $sIncName);
			if (!$oProperty->isPublic()) {
				// trying for a setter
				$sSetterName = 'set'.ucfirst($sIncName);
				$oSetter = new ReflectionMethod($this, $sSetterName);

				$oSetter->invoke($this, $value);
			} else {
				$oProperty->setValue($this, $value);
			}

			$this->sOffset = $sIncName;
			return;
		} catch (ReflectionException $e) {
//			$this->sOffset = $sIncName;
//			$this->$sIncName = $value;
		}

		parent::__set ($sIncName, $value);
	}

	public function __construct () {
		$this->rewind();
	}

	/**
	 * It should add a new property to the object
	 * @param string $sName
	 * @param mixed $mValue
	 */
	protected function addProperty ($sName, $mValue, $bIfNonExistent = false) {
		if ($bIfNonExistent) {
			try {
				$this->$sName = $mValue;
			} catch (vscExceptionUnimplemented $e) {
//				$this->$sName = $mValue;
			}
		}
	}

	protected function getProperties () {
		$aRet = array();
		$t = new ReflectionObject($this);
		$aProperties = $t->getProperties();

		/* @var $oProperty ReflectionProperty */
		foreach ($aProperties as $oProperty) {
			$sName = $oProperty->getName();
			$aRet[$sName] = $this->__get($sName);
		}
		return $aRet;
	}

	public function toArray () {
		return $this->getProperties();
	}
}