<?php
/**
 * @package vsc_presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 10.04.09
 */
import ('presentation/views');
class vscTxtView extends vscViewA implements vscViewI {
	protected $sContentType = 'text/plain';
	public function __construct () {
	}

	/**
	 * (non-PHPdoc)
	 * @see lib/presentation/views/vscViewI#append($tpl_var, $value, $merge)
	 */
	public function append ($tpl_var, $value=null, $merge=false) {}

	/**
	 * (non-PHPdoc)
	 * @see lib/presentation/views/vscViewI#assign($tpl_var, $value)
	 */
    public function assign ($tpl_var, $value = null) {}

	/**
	 * (non-PHPdoc)
	 * @see lib/presentation/views/vscViewI#display($resource_name, $cache_id, $compile_id)
	 */
    public function display ($resource_name) {}

	public function getViewFolder () {
		return 'txt';
	}
}