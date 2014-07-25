<?php
/**
 * @package vsc_presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.09.07
 */
vsc\import ('presentation/views');
vsc\import ('presentation/views/exceptions');

class vscXhtmlView extends vscViewA implements vscXhtmlViewI {
	protected $sContentType = 'application/xhtml+xml';
	protected $sFolder = 'xhtml';

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

   	public function getScripts($bInHead = false) {
   		try {
    		return $this->getMap()->getScripts($bInHead);
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
