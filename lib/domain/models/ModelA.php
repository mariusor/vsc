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
	use ArrayAccessT;
	use CountableT;
	use IteratorT;

	/**
	 * @param string $sIncName
	 * @return mixed
	 */
	public function __get($sIncName) {
		try {
			$oProperty = new \ReflectionProperty($this, $sIncName);
			if (!$oProperty->isPublic()) {
				// try for a getter method
				$sGetterName = 'get' . ucfirst($sIncName);
				$oGetter = new \ReflectionMethod($this, $sGetterName);

				$this->_current = $sIncName; // ?? I wonder if setting the offset to the current read position is the right way
				return $oGetter->invoke($this, $sIncName);
			} else {
				$this->_current = $sIncName; // ?? I wonder if setting the offset to the current read position is the right way
				return $oProperty->getValue($this);
			}
		} catch (\ReflectionException $e) {
			// reflection issue
			return parent::__get($sIncName);
		}
	}

	/**
	 * @param string $sIncName
	 * @param mixed $value
	 * @throws ExceptionUnimplemented
	 * @throws \ReflectionException
	 */
	public function __set($sIncName, $value) {
		if (is_null($sIncName)) {
			throw new \ReflectionException('Can\'t set a value to a null property on the current object [' . get_class($this) . ']');
		}
		try {
			$oProperty = new \ReflectionProperty($this, $sIncName);
			if (!$oProperty->isPublic()) {
				// trying for a setter
				$sSetterName = 'set' . ucfirst($sIncName);
				$oSetter = new \ReflectionMethod($this, $sSetterName);

				$oSetter->invoke($this, $value);
			} else {
				$oProperty->setValue($this, $value);
			}

			$this->_current = $sIncName;
			return;
		} catch (\ReflectionException $e) {
//			$this->_current = $sIncName;
//			$this->$sIncName = $value;
		}

		parent::__set($sIncName, $value);
	}

	public function __construct() {
		$this->rewind();
	}

	/**
	 * @param bool $bAll
	 * @return array
	 */
	protected function getPropertyNames($bAll = false) {
		$aRet = array();
		$oMirror = new \ReflectionObject($this);
		$aProperties = $oMirror->getProperties();

		/* @var $oProperty \ReflectionProperty */
		foreach ($aProperties as $oProperty) {
			// skip locally defined properties
			if ($oProperty->getDeclaringClass()->getName() == ModelA::class) { continue; }
			if ($bAll || (!$bAll && $oProperty->isPublic())) {
				$aRet[] = $oProperty->getName();
			}
		}
		return $aRet;
	}

	/**
	 * @param bool $bIncludeProtected
	 * @return array
	 */
	protected function getProperties($bIncludeProtected = false) {
		$aRet = array();
		$oMirror = new \ReflectionObject($this);
		$aProperties = $oMirror->getProperties();

		/* @var $oProperty \ReflectionProperty */
		foreach ($aProperties as $oProperty) {
			$sName = $oProperty->getName();
			if ($oProperty->isPublic()) {
				$aRet[$sName] = $oProperty->getValue($this);
			} elseif ($bIncludeProtected) {
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
