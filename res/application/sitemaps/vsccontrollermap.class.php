<?php
/**
 * @package vsc_application
 * @subpackage sitemaps
 * @author marius orcisk <marius@habarnam.ro>
 * @date 10.12.05
 */

class vscControllerMap extends vscMappingA implements vscContentTypeMappingI {
	private $sMainTemplatePath;
	private $sMainTemplate;

	public function setMainTemplatePath ($sPath) {
		$this->sMainTemplatePath = $sPath;
	}

	public function getMainTemplatePath () {
		// if we didn't provide the controller with a main template path we check the module
		if ( is_null($this->sMainTemplatePath))
			if ( $this->getModuleMap() instanceof vscContentTypeMappingI)
				$this->sMainTemplatePath = $this->getModuleMap()->getMainTemplatePath();
		return $this->sMainTemplatePath;
	}

	public function setMainTemplate ($sPath) {
		$this->sMainTemplate = $sPath;
	}

	public function getMainTemplate () {
		// if we didn't provide the controller with a main template path we check the module
		if ( is_null($this->sMainTemplate ) )
			if ( $this->getModuleMap() instanceof vscContentTypeMappingI)
				$this->sMainTemplate = $this->getModuleMap()->getMainTemplate();
		return $this->sMainTemplate;
	}
}