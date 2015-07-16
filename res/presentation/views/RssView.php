<?php
/**
 * @package presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.11.19
 */
namespace vsc\presentation\views;

class RssView extends ViewA implements RssViewI {
	protected $sContentType = 'application/rss+xml';
	protected $sFolder = 'rss';

	/**
	 * (non-PHPdoc)
	 * @see lib/presentation/views/vscViewI#append($tpl_var, $value, $merge)
	 */
	public function append($tplVar, $value = null, $merge = false) {}

	/**
	 * (non-PHPdoc)
	 * @see lib/presentation/views/vscViewI#assign($tpl_var, $value)
	 */
	public function assign($tplVar, $value = null) {}

	/**
	 * (non-PHPdoc)
	 * @see lib/presentation/views/vscViewI#display($resource_name, $cache_id, $compile_id)
	 */
	public function display($resourceName) {}

	/**
	 * @return string
	 */
	public function getDescription() {
		return '';
	}
	/**
	 * @return string
	 */
	public function getLanguage() {
		return '';
	}
	/**
	 * @return string
	 */
	public function getLastBuildDate() {
		return '';
	}
}
