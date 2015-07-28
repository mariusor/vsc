<?php
/**
 * @package presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.09.07
 */
namespace vsc\presentation\views;

class XhtmlView extends ViewA implements XhtmlViewI {
	protected $sContentType = 'application/xhtml+xml';
	protected $sFolder = 'xhtml';

	public function getContent() {
		return '';
	}

   	public function getScripts($bInHead = false) {
   		try {
			return $this->getMap()->getScripts($bInHead);
		} catch (ExceptionView $e) {
			return array();
		}
   	}

	public function getMetaHeaders() {
		try {
			return $this->getMap()->getMetas();
		} catch (ExceptionView $e) {
			return array();
		}
	}

	public function getStyles() {
		try {
			return $this->getMap()->getStyles();
		} catch (ExceptionView $e) {
			return array();
		}
	}

	public function getSetting($sVar) {
		try {
			return $this->getMap()->getSetting($sVar);
		} catch (ExceptionView $e) {
			return '';
		}
	}

	public function getLinks($sType = null) {
		try {
			return $this->getMap()->getLinks($sType);
		} catch (ExceptionView $e) {
			return '';
		}
	}
}
