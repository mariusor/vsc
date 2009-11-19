<?php
/**
 * @package vsc_presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.09.07
 */
class vscDefaultView extends vscViewA {
	/**
	 * (non-PHPdoc)
	 * @see lib/presentation/views/vscViewI#append($tpl_var, $value, $merge)
	 */
	function append($tpl_var, $value=null, $merge=false) {}

	/**
	 * (non-PHPdoc)
	 * @see lib/presentation/views/vscViewI#assign($tpl_var, $value)
	 */
    function assign($tpl_var, $value = null) {}

	/**
	 * (non-PHPdoc)
	 * @see lib/presentation/views/vscViewI#display($resource_name, $cache_id, $compile_id)
	 */
    function display($resource_name, $cache_id = null, $compile_id = null) {}

    /**
     * (non-PHPdoc)
     * @see lib/presentation/views/vscViewI#fetch($resource_name, $cache_id, $compile_id, $display)
     */
    function fetch($resource_name, $cache_id = null, $compile_id = null, $display = false) {}
}