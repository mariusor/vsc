<?php
/**
 * @package vsc_domain
 * @subpackage domain
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.04.27
 */
import (VSC_LIB_PATH . 'domain/domain/indexes');

class vscKeyPrimary extends vscIndexA  {
	public function __construct ($mIncomingStuff) {
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

	public function getName () {
		return $this->name;
	}

	public function setName ($sName) {
		$this->name = $sName . '_pk';
	}

	public function getType() {
		return vscIndexType::PRIMARY;
	}

	public function getDefinition () {
		// this is totally wrong for PostgreSQL
		return	'PRIMARY KEY ' . $this->getName() . ' (' . $this->getIndexComponents(). ')';
	}
}