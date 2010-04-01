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
			unset($this->$sIncName);
		}
	}

	public function offsetGet($offset) {
		return $this->__get($offset);
	}

	// Iterator interface
	public function  current  () {
		return $this->offsetGet($this->sOffset);
	}

	public function key () {
		return $this->sOffset;
	}

	public function next () {
		$aProperties = $this->getProperties();
		ksort($aProperties);
		$aKeys = array_keys ($aProperties);

		if (in_array($this->sOffset, $aKeys));
			$iNext = key($aKeys)+1;

		return $iNext;
	}
	public function rewind () {
		$aProperties = $this->getProperties();
		ksort($aProperties);
		$aKeys = array_keys ($aProperties);

		if (in_array($this->sOffset, $aKeys));
			$iPrev = key($aKeys)-1;

		return $iPrev;
	}
	public function valid () {
		return (in_array($this->getProperties(), $this->sOffset));
	}

	// Countable interface
	public function count () {
		return count ($this->toArray());
	}

	public function __get ($sIncName) {
		try {
			$oProperty = new ReflectionProperty($this, $sIncName);
		} catch (ReflectionException $e) {
			//
		}
		if (!$oProperty->isPrivate()) {
			// setting $sIncName to be the current element
			$this->sOffset = $sIncName;
			return $this->$sIncName;
		}
	}

	public function __set($sIncName, $value) {
		$oProperty = new ReflectionProperty($this, $sIncName);
		$sSetterName = 'set'.ucfirst($sIncName);
		$oSetter = new ReflectionMethod($this, $sSetterName);
//		d ($oSetter);
		if (!$oProperty->isPrivate()) {
			// setting $sIncName to be the current element
			$this->sOffset = $sIncName;
			$sSetterName = 'set'.ucfirst($sIncName);
			$oSetter = new ReflectionMethod($this, $sSetterName);
//			d ($oSetter);

			$this->$sSetterName($value);
		}
	}

	private function getProperties () {
		$aRet = array();
		$t = new ReflectionObject($this);
		$aProperties = $t->getProperties();

		/* @var $oProperty ReflectionProperty */
		foreach ($aProperties as $oProperty) {
			if (!$oProperty->isPrivate()) {
				$aRet[$oProperty->getName()] = $this->__get($oProperty->getName());
			}
		}
		return $aRet;
	}

	public function toArray () {
		return $this->getProperties();
	}
}