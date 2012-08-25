<?php
class vscJsonRPCResponse extends vscModelA {
	public $id = null;
	public $result = null;
	public $error = null;

	/**
	 *
	 * Enter description here ...
	 * @param bool $bIncludeNonPublic
	 */
	protected function getProperties ($bIncludeNonPublic = false) {
		$aRet = array();
		$t = new ReflectionObject($this);
		$aProperties = $t->getProperties();

		/* @var $oProperty ReflectionProperty */
		foreach ($aProperties as $oProperty) {
			$sName = $oProperty->getName();
			if ($oProperty->isPublic()) {
				$aRet[$sName] = $oProperty->getValue($this);
			}
		}
		return $aRet;
	}

}