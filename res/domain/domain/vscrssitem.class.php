<?php
/**
 * @package vsc_domain
 * @subpackage domain
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.04.14
 */
namespace vsc\domain\domain;

class vscRssItem extends vscModelA {
	public $title;
	public $link;
	public $category;
	public $description;
	public $pubDate;
	public $guid;

	public function __construct (DOMNode $oNode) {
		$this->buildObj ($oNode);
	}

	public function buildObj (DOMNode $oNode) {
		if ( $oNode->nodeName == 'item' && $oNode->childNodes instanceof DOMNodeList) {
			foreach ($oNode->childNodes as $oChildNode) {
				$sName = $oChildNode->nodeName;
				if (
					$oChildNode->nodeType == XML_ELEMENT_NODE &&
					$this->valid ($sName)
				) {
					try {
						if (!is_null ($this->$sName)) {
							$sInitial = $this->$sName;
							if (!is_array ($sInitial)) {
								$sInitial = array ($sInitial);
							}
							$this->$sName = array_merge($sInitial,array($oChildNode->nodeValue));
						} else {
							$this->$sName = $oChildNode->nodeValue;
						}
					} catch (vscExceptionUnimplemented $e) {
						// problem
					}
				} else {
					continue;
				}
			}
		}
	}
}