<?php
/**
 * @package domain
 * @subpackage models
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.11.19
 */
namespace vsc\domain\models;

use vsc\infrastructure\Base;
use vsc\ExceptionUnimplemented;

abstract class ModelA extends Base implements ModelI {
	/**
	 * @var string
	 */
	private $sOffset;

	/**
	 * @param string $sOffset
	 */
	public function setOffset($sOffset) {
		if ($this->offsetExists($sOffset))
			$this->sOffset = $sOffset;
	}

	/**
	 * @return string
	 */
	public function getOffset() {
		return $this->sOffset;
	}

	/**
	 * ArrayAccess interface
	 * @param mixed $sOffset
	 * @param mixed $mValue
	 * @throws
	 */
	public function offsetSet($sOffset, $mValue) {
		$this->__set($sOffset, $mValue);
	}

	/**
	 * @param string $sOffset
	 * @return bool
	 */
	public function offsetExists($sOffset) {
		return in_array($sOffset, $this->getPropertyNames());
	}

	/**
	 * @param string $sOffset
	 */
	public function offsetUnset($sOffset) {
		$oProperty = new \ReflectionProperty($this, $sOffset);
		if ($oProperty->isPublic()) {
			unset ($this->$sOffset);
		}
	}

	/**
	 * @param string $sOffset
	 * @return mixed
	 */
	public function offsetGet($sOffset) {
		return $this->__get($sOffset);
	}

	/**
	 * Iterator interface
	 * @return mixed
	 */
	public function current() {
		return $this->__get($this->sOffset);
	}

	/**
	 * @return string
	 */
	public function key() {
		return $this->sOffset;
	}

	public function next() {
		$aKeys = $this->getPropertyNames();

		$iCurrent = array_search($this->sOffset, $aKeys);

		if ($iCurrent+1 < $this->count()) {
			$this->sOffset = $aKeys[$iCurrent+1];
		} else {
			$this->sOffset = null;
		}
	}

	public function rewind() {
		$aKeys = $this->getPropertyNames();

		if (is_array($aKeys) && isset ($aKeys[0])) {
			$this->sOffset = $aKeys[0];
		}
	}

	public function valid($sName = null) {
		$bRetValue = false;

		if ($sName === null)
			$sName = $this->sOffset;

		$aKeys = $this->getPropertyNames();

		if (in_array($sName, $aKeys)) {
			return true;
		}

		return false;
	}

	// Countable interface
	public function count() {
		return count($this->getPropertyNames());
	}

	public function __get($sIncName) {
		try {
			$oProperty = new \ReflectionProperty($this, $sIncName);
			if (!$oProperty->isPublic()) {
				// try for a getter method
				$sGetterName = 'get'.ucfirst($sIncName);
				$oGetter = new \ReflectionMethod($this, $sGetterName);

				$this->sOffset = $sIncName; // ?? I wonder if setting the offset to the current read position is the right way
				return $oGetter->invoke($this, $sIncName);
			} else {
				$this->sOffset = $sIncName; // ?? I wonder if setting the offset to the current read position is the right way
				return $oProperty->getValue($this);
			}
		} catch (\ReflectionException $e) {
			// reflection issue
			return null;
		}
		return parent::__get($sIncName);
	}

	public function __set($sIncName, $value) {
		if (is_null($sIncName)) {
			throw new \ReflectionException('Can\'t set a value to a null property on the current object ['.get_class($this).']');
		}
		try {
			$oProperty = new \ReflectionProperty($this, $sIncName);
			if (!$oProperty->isPublic()) {
				// trying for a setter
				$sSetterName = 'set'.ucfirst($sIncName);
				$oSetter = new \ReflectionMethod($this, $sSetterName);

				$oSetter->invoke($this, $value);
			} else {
				$oProperty->setValue($this, $value);
			}

			$this->sOffset = $sIncName;
			return;
		} catch (\ReflectionException $e) {
//			$this->sOffset = $sIncName;
//			$this->$sIncName = $value;
		}

		parent::__set($sIncName, $value);
	}

	public function __construct() {
		$this->rewind();
	}

	/**
	 * It should add a new property to the object
	 * @param string $sName
	 * @param mixed $mValue
	 */
	protected function addProperty($sName, $mValue, $bIfNonExistent = false) {
		if ($bIfNonExistent) {
			try {
				$this->$sName = $mValue;
			} catch (ExceptionUnimplemented $e) {
//				$this->$sName = $mValue;
			}
		}
	}

	protected function getPropertyNames($bAll = false) {
		$aRet = array();
		$t = new \ReflectionObject($this);
		$aProperties = $t->getProperties();

		/* @var $oProperty \ReflectionProperty */
		foreach ($aProperties as $oProperty) {
			if ($bAll || (!$bAll && $oProperty->isPublic())) {
				$aRet[] = $oProperty->getName();
			}
		}
		return $aRet;
	}

	/**
	 * @param bool $bIncludeNonPublic
	 * @return array
	 */
	protected function getProperties($bIncludeNonPublic = false) {
		$aRet = array();
		$t = new \ReflectionObject($this);
		$aProperties = $t->getProperties();

		/* @var $oProperty \ReflectionProperty */
		foreach ($aProperties as $oProperty) {
			$sName = $oProperty->getName();
			if ($oProperty->isPublic()) {
				$aRet[$sName] = $oProperty->getValue($this);
			} elseif ($bIncludeNonPublic) {
				$oProperty->setAccessible(true);
				$aRet[$sName] = $oProperty->getValue($this);
			}
		}
		return $aRet;
	}

	/**
	 * recursively transform all properties into arrays
	 */
	public function toArray() {
		$aRet = array();
		$aProperties = $this->getProperties();
		foreach ($aProperties as $sName => $oProperty) {
			if (ModelA::isValid($oProperty)) {
				/* @var ModelA $oProperty */
				$aRet[$sName] = $oProperty->toArray();
			} elseif (is_array($oProperty) || is_scalar($oProperty)) {
				$aRet[$sName] = $oProperty;
			} elseif (is_null($oProperty)) {
				$aRet[$sName] = $oProperty;
			} else {
				$aRet[$sName] = var_export($oProperty, true);
			}
		}

		return $aRet;
	}
}
