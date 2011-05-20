<?php
/**
 * @package vsc_domain
 * @subpackage domain
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.03.19
 */
abstract class vscIndexA extends vscObject implements vscFieldI  {
	protected $name;
	protected $fields = array();

	public function __construct ($mIncomingStuff = null) {
		if (vscFieldA::isValid($mIncomingStuff)) {
			$this->setName ($mIncomingStuff->getName());
			$this->addField ($mIncomingStuff);
		} elseif (is_array ($mIncomingStuff)) {
			$this->setName($mIncomingStuff[0]->getName());
			foreach ($mIncomingStuff as $oField) {
				if (vscFieldA::isValid($oField))
					$this->addField ($oField);
				else
					throw new vscIndexException ('The object passed can not be used as an index.');
			}
		} else {
			throw new vscIndexException ('The data used to instantiate the table\'s primary key is invalid.');
		}
	}

	public function getName () {
		return $this->name;
	}

//	abstract public function setName ($sName);

	public function addField (vscFieldA $oField) {
		$this->fields[$oField->getName()] = $oField;
	}

	/**
	 *
	 * @return vscFieldA[]
	 */
	public function getFields () {
		return $this->fields;
	}

//	public function removeField (vscFieldA $oField) {
//		if (isset ($this->fields[$oField->getName()]))
//			unset($this->fields[$oField->getName()]);
//	}

	public function hasField (vscFieldA $oField) {
		return (key_exists($oField->getName(), $this->fields) && vscFieldA::isValid($oField));
	}

	public function getIndexComponents () {
		return implode (', ', array_keys($this->fields));
	}

	static public function isValid ($oIndex) {
		return ($oIndex instanceof static);
	}

	public function __toString() {
		return implode ('.', $this->getFields());
	}
}