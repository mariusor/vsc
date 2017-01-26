<?php
/**
 * @package domain
 * @subpackage domain
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.04.14
 */
namespace vsc\domain\domain;

use vsc\domain\models\ModelA;
use vsc\ExceptionUnimplemented;

class RssItem extends ModelA {
	public $title;
	public $link;
	public $category;
	public $description;
	public $pubDate;
	public $guid;

	public function __construct(\DOMNode $oNode = null) {
		if (!is_null($oNode)) {
			$this->buildObj($oNode);
		}
		parent::__construct();
	}

	public function buildObj(\DOMNode $oNode) {
		if ($oNode->nodeName == 'item' && $oNode->childNodes instanceof \DOMNodeList) {
			foreach ($oNode->childNodes as $oChildNode) {
				$sName = $oChildNode->nodeName;
				if (
					$oChildNode->nodeType != XML_ELEMENT_NODE
				) {
					continue;
				}
				try {
					$this->$sName = $oChildNode->nodeValue;
				} catch (ExceptionUnimplemented $e) {
					// problem
				}
			}
		}
	}
}
