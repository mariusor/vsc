<?php
/**
 * @package vsc_domain
 * @subpackage models
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2012.08.25
 */
namespace vsc\domain\models;

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