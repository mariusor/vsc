<?php
/**
 * @package ts_models
 * @author Marius Orcsik <marius@habarnam.ro>
 * @date 09.03.19
 */
//define ('INDEX',	1);
//define ('PRIMARY',	2);
//define ('UNIQUE',	4);
//define ('FULLTEXT',	8);
abstract class fooIndexA implements fooFieldI  {
	protected $name;
	protected $fields = array();

	public function __construct ($mIncomingStuff = null) {
		if (is_array ($mIncomingStuff)) {
			$this->setName($mIncomingStuff[0]->getName());
			foreach ($mIncomingStuff as $oField) {
				if (fooFieldA::isValid($oField))
					$this->addField ($oField);
				else
					throw new fooIndexException ('The object passed can not be used as a primary key.');
			}
		} else {
			throw new fooIndexException ('The data used to instantiate the table\'s primary key is invalid.');
		}
	}

//	abstract public function getName ();

//	abstract public function setName ($sName);

	public function addField (fooFieldA $oField) {
		$this->fields[$oField->getName()] = $oField;
	}

//	public function removeField (fooFieldA $oField) {
//		if (isset ($this->fields[$oField->getName()]))
//			unset($this->fields[$oField->getName()]);
//	}

	public function getIndexComponents () {
		return implode (', ', array_keys($this->fields));
	}
}