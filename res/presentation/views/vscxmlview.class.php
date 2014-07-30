<?php
/**
 * @package vsc_presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2012.08.26
 */
namespace vsc\presentation\views;

vsc\import ('presentation/views');
vsc\import ('presentation/views/exceptions');

class vscXmlView extends vscViewA implements vscXmlViewI {
	protected $sContentType = 'application/xml';
	protected $sFolder = 'xml';

	public function getContent () {
		return '';
	}

	public function getMetaHeaders() {
		return '';
	}

	/**
	 * (non-PHPdoc)
	 * @see lib/presentation/views/vscViewI#append($tpl_var, $value, $merge)
	 */
	public function append($tpl_var, $value=null, $merge=false) {
//		d ($tpl_var, $value, $merge);
	}

	/**
	 * (non-PHPdoc)
	 * @see lib/presentation/views/vscViewI#assign($tpl_var, $value)
	 */
	public function assign($tpl_var, $value = null) {
//		d ($tpl_var, $value);
	}

	/**
	 * (non-PHPdoc)
	 * @see lib/presentation/views/vscViewI#display($resource_name, $cache_id, $compile_id)
	 */
	public function display ($resource_name) {
		d ($resource_name);
	}
}
