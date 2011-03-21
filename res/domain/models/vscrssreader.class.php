<?php
/**
 * @package vsc_domain
 * @subpackage models
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.04.13
 */
import (VSC_RES_PATH . 'domain/domain');
class vscRssReader extends vscXmlReader {
	public $title;
	public $link;
	public $description;
	public $generator;
	public $docs;
	public $language;
	public $pubDate;
	public $lastBuildDate;
	private $items = array();

	public function getItems () {
		return $this->items;
	}

	public function setItems ($aItems) {
		$this->items = $aItems;
	}

	public function addItem (vscRssItem $oElement) {
		$this->items[] = $oElement;
	}

	public function getItem ($iIndex) {
		if (isset ($this->items[$iIndex])) {
			return $this->items[$iIndex];
		} else {
			return new vscNull();
		}
	}

	public function buildObj() {
		parent::buildObj();

		$oNode = $this->getDom()->getElementsByTagName('channel')->item(0);
		if ($oNode instanceof DOMElement) {
			$this->parseToEntity ($oNode->childNodes);
		}
	}

	public function parseToEntity ($aChildNodes) {
		if ($aChildNodes instanceof DOMNodeList) {
			foreach ($aChildNodes as $oChildNode) {
				$sNodeName = $oChildNode->nodeName;
				if ($oChildNode->nodeType == XML_ELEMENT_NODE) {
					if ($sNodeName == 'item') {
						$oRssItem = new vscRssItem ($oChildNode);
						$this->addItem ($oRssItem);
					} elseif ($this->valid($sNodeName)) {
						try {
							$this->$sNodeName = $oChildNode->nodeValue;
						} catch (vscExceptionUnimplemented $e) {
							// the property didn't exist
						}
					}
				}
			}
		}
	}
}