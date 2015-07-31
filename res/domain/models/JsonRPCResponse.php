<?php
/**
 * @package domain
 * @subpackage models
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2012.08.25
 */
namespace vsc\domain\models;

class JsonRPCResponse extends ModelA {
	public $id = null;
	public $result = null;
	public $error = null;

	/**
	 *
	 * @param bool $bIncludeProtected
	 * @return array
	 */
	protected function getProperties($bIncludeProtected = false) {
		$aRet = array();
		$t = new \ReflectionObject($this);
		$aProperties = $t->getProperties();

		/* @var $oProperty \ReflectionProperty */
		foreach ($aProperties as $oProperty) {
			$sName = $oProperty->getName();

			if ($oProperty->isPrivate() || $sName == '_current') {
				// skip private properties or IteratorT::$_current
				continue;
			} elseif ($oProperty->isProtected()) {
				if ($bIncludeProtected) {
					$oProperty->setAccessible(true);
				} else {
					continue;
				}
			}
			$aRet[$sName] = $oProperty->getValue($this);
		}
		return $aRet;
	}

}
