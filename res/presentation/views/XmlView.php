<?php
/**
 * @package presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2012.08.26
 */
namespace vsc\presentation\views;

class XmlView extends ViewA implements XmlViewI {
	protected $sContentType = 'application/xml';
	protected $sFolder = 'xml';

	public function getContent() {
		return '';
	}

	public function getMetaHeaders() {
		return [];
	}
}
