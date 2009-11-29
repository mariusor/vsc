<?php
/**
 * @package vsc_presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.11.19
 */
class vscRssView extends vscViewA implements vscRssViewI {
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

	public function getOutput () {
		return $this->fetch (VSC_RES_PATH . 'templates' . DIRECTORY_SEPARATOR . 'rss/main.php');
	}

	public function getUrl(){}
	public function getTitle(){}
	public function getDescription(){}
	public function getLanguage(){}
	public function getLastBuildDate(){}
}