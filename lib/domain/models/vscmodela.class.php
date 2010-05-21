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
		return $this->__get($this->sOffset);
	}

	public function key () {
		return $this->sOffset;
	}

	public function next () {
		$aKeys = $this->getPropertyNames();

		$iCurrent = array_search($this->sOffset, $aKeys);

		if ($iCurrent+1 < $this->count()) {
			$this->sOffset = $aKeys[$iCurrent+1];
		} else {
			$this->sOffset = null;
		}
	}

	public function rewind () {
		$aKeys = $this->getPropertyNames();

		if (is_array($aKeys) && isset ($aKeys[0]))
			$this->sOffset = $aKeys[0];
	}

	public function valid ($sName = null) {
		$bRetValue = false;
		if ($sName !== null) {
			$this->sOffset = $sName;
		}
		$oRObject = new ReflectionObject ($this);
		try {
			$bRetValue = (bool)($oRObject->hasProperty($this->sOffset) && $oRObject->getProperty($this->sOffset)->isPublic());
		} catch (ReflectionException $e) {
			$bRetValue = false;
		}

		return $bRetValue;
	}

	// Countable interface
	public function count () {
		return count ($this->getPropertyNames());
	}

	public function __get ($sIncName = null) {
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
//			d ($e);
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

	protected function getPropertyNames ($bAll = false) {
		$aRet = array();
		$t = new ReflectionObject($this);
		$aProperties = $t->getProperties();

		/* @var $oProperty ReflectionProperty */
		foreach ($aProperties as $oProperty) {
			if ($bAll || (!$bAll && $oProperty->isPublic() )) {
				$aRet[] = $oProperty->getName();
			}
		}
		return $aRet;
	}

	protected function getProperties ($bAll = false) {
		$aRet = array();
		$t = new ReflectionObject($this);
		$aProperties = $t->getProperties();

		/* @var $oProperty ReflectionProperty */
		foreach ($aProperties as $oProperty) {
			if (!$bAll && $oProperty->isPublic()) {
				$sName = $oProperty->getName();
				$aRet[$sName] = $oProperty->getValue($this);
			} elseif ($bAll) {
				$sName = $oProperty->getName();
				$oProperty->setAccessible(true);
				$aRet[$sName] = $oProperty->getValue($this);
			}
		}
		return $aRet;
	}

	/**
	 * recursively transform all properties into arrays
	 */
	public function toArray () {
		$aProperties = $this->getProperties(true);
		foreach ($aProperties as $sName => $oProperty) {
			if ($oProperty instanceof vscModelA) {
				$aRet[$sName] = $oProperty->toArray();
			} elseif (is_array($oProperty) || is_scalar($oProperty)) {
				$aRet[$sName] = $oProperty;
			} else {
				$aRet[$sName] = var_export($oProperty,true);
			}
		}

		return $aRet;
	}
}