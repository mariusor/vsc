<?php
/**
 * @package vsc_presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.09.07
 */
class vscXhtmlView extends vscViewA implements vscXhtmlViewI {
	/**
	 * (non-PHPdoc)
	 * @see lib/presentation/views/vscViewI#append($tpl_var, $value, $merge)
	 */
	public function append($tpl_var, $value=null, $merge=false) {}

	/**
	 * (non-PHPdoc)
	 * @see lib/presentation/views/vscViewI#assign($tpl_var, $value)
	 */
    public function assign($tpl_var, $value = null) {}

	/**
	 * (non-PHPdoc)
	 * @see lib/presentation/views/vscViewI#display($resource_name, $cache_id, $compile_id)
	 */
    public function display($resource_name) {}

    /**
     * (non-PHPdoc)
     * @see lib/presentation/views/vscViewI#fetch($resource_name, $cache_id, $compile_id, $display)
     */
    public function fetch($sTplPath) {
    	return parent::fetch($sTplPath);
    }

   	public function getScripts() {}

	public function getContent() {
		return parent::getContent();
	}

	public function getMetaHeaders() {}

	public function getStyleSheets() {}
}