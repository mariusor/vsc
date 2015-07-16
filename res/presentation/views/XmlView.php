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

	/**
	 * (non-PHPdoc)
	 * @see lib/presentation/views/vscViewI#append($tpl_var, $value, $merge)
	 */
	public function append($tplVar, $value = null, $merge = false) { }

	/**
	 * (non-PHPdoc)
	 * @see lib/presentation/views/vscViewI#assign($tpl_var, $value)
	 */
	public function assign($tplVar, $value = null) { }

	/**
	 * (non-PHPdoc)
	 * @see lib/presentation/views/vscViewI#display($resource_name, $cache_id, $compile_id)
	 */
	public function display($resourceName) {
		return '';
	}
}
