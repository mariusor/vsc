<?php
/**
 * @package domain
 * @subpackage domain
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.03.19
 */

abstract class vscIndexA implements vscFieldI  {
	protected $name;
	protected $fields = array();

	public function __construct ($mIncomingStuff = null) {
		if (is_array ($mIncomingStuff)) {
			$this->setName($mIncomingStuff[0]->getName());
			foreach ($mIncomingStuff as $oField) {
				if (vscFieldA::isValid($oField))
					$this->addField ($oField);
				else
					throw new vscIndexException ('The object passed can not be used as a primary key.');
			}
		} else {
			throw new vscIndexException ('The data used to instantiate the table\'s primary key is invalid.');
		}
	}

//	abstract public function getName ();

//	abstract public function setName ($sName);

	public function addField (vscFieldA $oField) {
		$this->fields[$oField->getName()] = $oField;
	}

//	public function removeField (vscFieldA $oField) {
//		if (isset ($this->fields[$oField->getName()]))
//			unset($this->fields[$oField->getName()]);
//	}

	public function getIndexComponents () {
		return implode (', ', array_keys($this->fields));
	}
}