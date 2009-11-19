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

	public function getOutput() {
    	return $this->fetch(VSC_RES_PATH . 'templates' . DIRECTORY_SEPARATOR . 'xhtml/main.php');
    }

   	public function getScripts() {}

	public function getMetaHeaders() {}

	public function getStyleSheets() {}
}