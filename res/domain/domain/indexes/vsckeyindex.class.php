<?php
/**
 * @package vsc_domain
 * @subpackage domain
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.04.27
 */
import (VSC_LIB_PATH . 'domain/domain/indexes');

class vscKeyIndex extends vscIndexA  {
	public function __construct (vscFieldI $oField) {
		$mIncomingStuff = func_get_args();

		$aRet = array();
		if (vscFieldA::isValid($mIncomingStuff)) {
			$mIncomingStuff->setIsNullable(false);
			parent::__construct ($mIncomingStuff);
		} elseif (is_array($mIncomingStuff)) {
			/* @var $oField vscFieldA */
			foreach ($mIncomingStuff as $oField) {
				// enforcing NOT NULL constraints on the components of the primary key
				if (vscFieldA::isValid($oField)) {
					$oField->setIsNullable(false);
					$aRet[] = $oField;
				} else {
					throw new vscIndexException('The object passed can not be used as a primary key.');
				}
			}
			parent::__construct($aRet);
		}
	}

	public function setName ($sName) {
		$this->name = $sName . '_idx';
	}

	public function getType() {
		return vscIndexType::INDEX;
	}

}
