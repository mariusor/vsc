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
	private $oPayload;

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

	public function buildObj() {
		$xml = new DOMDocument();
		if (@$xml->loadXML($this->sXmlString)) {
			$xml->normalizeDocument();
			$oNode = $xml->getElementById(0);
			if ($oNode instanceof DOMElement) {
				return $this->parseXmlToArray ($oNode->childNodes);
			} else {
				return array();
			}
		} else {
			return array();
		}
	}
}