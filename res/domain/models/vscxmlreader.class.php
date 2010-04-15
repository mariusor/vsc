<?php
/**
 * @package vsc_domain
 * @subpackage models
 * @author marius orcsik <marius@habarnam.ro>
 * @date 10.04.13
 */
import ('domain/models');
import ('domain/exceptions');
class vscXmlReader extends vscModelA {
	private $sXmlString;
	private $oDOM;

	public function __construct () {
		if (!extension_loaded('dom')) {
			throw new vscExceptionUnimplemented('The DOM extension is not loaded');
		}
		parent::__construct();
	}

	public function setString ($sString) {
		$this->sXmlString = $sString;
	}

	public function getString () {
		return $this->sXmlString;
	}

	public function getDom () {
		return $this->oDOM;
	}

	public function buildObj () {
		$this->oDOM = new DOMDocument();
		$this->oDOM->strictErrorChecking = false;


		if ($this->oDOM->loadXML($this->getString())) {
			$this->oDOM->normalizeDocument();
		}
	}
}