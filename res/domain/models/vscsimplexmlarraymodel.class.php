<?php

import ('domain/models');
class vscSimpleXMLArrayModel extends vscModelA {
	private $oSimpleXML;

	public function __construct ($oSimpleXML) {
		$this->oSimpleXML = $oSimpleXML;

		parent::__construct();
	}

	public function __get ($sName) {
		return $this->oSimpleXML->{$sName};
	}

	public function __set ($sName, $mValue) {
		// should be read-only
	}

	public function __call ($sMethodName, $aParameters) {
		$this->oSimpleXML->{$sMethodName} ($aParameters);
	}
}