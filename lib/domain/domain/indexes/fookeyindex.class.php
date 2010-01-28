<?php
/**
 * @package ts_models
 * @author Marius Orcsik <marius@habarnam.ro>
 * @date 09.04.27
 */

class fooKeyIndex extends fooIndexA  {
	public function __construct ($mIncomingStuff) {
		/* @var $oField fooFieldA */
		foreach ($mIncomingStuff as $oField) {
			// enforcing NOT NULL constraints on the components of the primary key
			if (fooFieldA::isValid($oField)) {
				$oField->setIsNullable(false);
				$aRet[] = $oField;
			} else {
				throw new fooIndexException('The object passed can not be used as a primary key.');
			}
		}
		parent::__construct($aRet);
	}

	public function getName () {
		return $this->name;
	}

	public function setName ($sName) {
		$this->name = $sName . '_idx';
	}

	public function getType() {
		return 'INDEX';
	}

	public function getDefinition () {
		// this is totally wrong for PostgreSQL
		return	'INDEX ' . $this->getName() . ' (' . $this->getIndexComponents(). ')';
	}
}