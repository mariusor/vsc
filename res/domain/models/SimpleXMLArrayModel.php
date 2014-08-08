<?php
/**
 * @package domain
 * @subpackage models
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2012.12.25
 */
namespace vsc\domain\models;

// \vsc\import ('domain/models');
class SimpleXMLArrayModel extends ModelA {
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
