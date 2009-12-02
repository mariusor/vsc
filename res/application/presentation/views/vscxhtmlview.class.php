<?php
/**
 * @package vsc_presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.09.07
 */
import ('presentation/views');
class vscXhtmlView extends vscViewA implements vscXhtmlViewI {

	public function __construct () {
//		$this->setTemplate(VSC_RES_PATH . 'templates' . DIRECTORY_SEPARATOR . 'xhtml/content.php');
	}

	public function getContent () {
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
//    	d ($tpl_var, $value);
    }

	/**
	 * (non-PHPdoc)
	 * @see lib/presentation/views/vscViewI#display($resource_name, $cache_id, $compile_id)
	 */
    public function display ($resource_name) {
    	d ($resource_name);
    }

	public function getOutput() {
    	return $this->fetch (VSC_RES_PATH . 'templates' . DIRECTORY_SEPARATOR . 'xhtml/main.php');
    }

   	public function getScripts() {
   		return $this->getMap()->getScripts();
   	}

	public function getMetaHeaders() {
		return $this->getMap()->getMetas();
	}

	public function getStyles() {
		return $this->getMap()->getStyles();
	}

	public function getSetting ($sVar) {
		return $this->getMap()->getSetting($sVar);
	}

}