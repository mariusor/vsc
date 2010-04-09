<?php
/**
 * @package vsc_presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 10.04.09
 */
import ('presentation/views');
class vscJsonView extends vscViewA implements vscJsonViewI {
	protected $sContentType = 'application/rss+xml';
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
		return 'json';
	}

	public function getDescription(){}
	public function getLanguage(){}
	public function getLastBuildDate(){}
}