<?php
/**
 * @package domain
 * @subpackage models
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.04.13
 */
namespace vsc\domain\models;

// \vsc\import ('domain/models');
// \vsc\import ('domain/exceptions');
use vsc\ExceptionUnimplemented;

class XmlReader extends ModelA {
	private $sXmlString;
	private $oDOM;

	public function __construct () {
		if (!extension_loaded('dom')) {
			throw new ExceptionUnimplemented('The DOM extension is not loaded');
		}
		parent::__construct();
	}

	public function setString ($sString) {
		$this->sXmlString = $sString;
	}

	public function getString () {
		return $this->sXmlString;
	}

	/**
	 * @return \DOMDocument
	 */
	public function getDom () {
		return $this->oDOM;
	}

	public function buildObj () {
		$this->oDOM = new \DOMDocument();
		$this->oDOM->strictErrorChecking = false;


		if ($this->oDOM->loadXML($this->getString())) {
			$this->oDOM->normalizeDocument();
		}
	}
}
