<?php
/**
 * @package vsc_presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.09.07
 */
import ('presentation/views');
import ('presentation/views/exceptions');
class vscXhtmlView extends vscViewA implements vscXhtmlViewI {
	protected $sContentType = 'text/html';
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
		try {
    		return $this->fetch (VSC_RES_PATH . 'templates' . DIRECTORY_SEPARATOR . 'xhtml/main.php');
		} catch (vscExceptionView $e) {
			return '';
		}
    }

   	public function getScripts() {
   		try {
    		return $this->getMap()->getScripts();
		} catch (vscExceptionView $e) {
			return array();
		}
   	}

	public function getMetaHeaders() {
		try {
    		return $this->getMap()->getMetas();
		} catch (vscExceptionView $e) {
			return array();
		}
	}

	public function getStyles() {
		try {
    		return $this->getMap()->getStyles();
		} catch (vscExceptionView $e) {
			return array();
		}
	}

	public function getSetting ($sVar) {
		try {
			return $this->getMap()->getSetting($sVar);
		} catch (vscExceptionView $e) {
			return '';
		}
	}

	public function getLinks ($sType = null) {
		try {
			return $this->getMap()->getLinks($sType);
		} catch (vscExceptionView $e) {
			return '';
		}
	}

}