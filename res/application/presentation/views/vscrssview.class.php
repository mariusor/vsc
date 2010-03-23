<?php
/**
 * @package vsc_presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.11.19
 */
import ('presentation/views');
class vscRssView extends vscViewA implements vscRssViewI {
	protected $sContentType = 'application/rss+xml';
	public function __construct () {
		$this->setTemplate(VSC_RES_PATH . 'templates' . DIRECTORY_SEPARATOR . 'rss/content.php');
	}

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

	public function getViewFolder () {
		return 'rss';
	}

	public function getUrl(){}
	public function getTitle(){}
	public function getContent(){}
	public function getDescription(){}
	public function getLanguage(){}
	public function getLastBuildDate(){}
}