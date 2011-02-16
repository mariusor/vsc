<?php
/**
 * @package vsc_application
 * @subpackage sitemaps
 * @author marius orcisk <marius@habarnam.ro>
 * @date 10.12.05
 */

class vscModuleMap extends vscMappingA implements vscContentTypeMappingI{
	private $sMainTemplatePath;
	private $sMainTemplate;

	public function setMainTemplatePath ($sPath) {
		$this->sMainTemplatePath = $sPath;
	}

	public function getMainTemplatePath () {
		return $this->sMainTemplatePath;
	}

	public function setMainTemplate ($sPath) {
		$this->sMainTemplate = $sPath;
	}

	public function getMainTemplate () {
		return $this->sMainTemplate;
	}
}