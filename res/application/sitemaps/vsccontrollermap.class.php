<?php
/**
 * @package vsc_application
 * @subpackage sitemaps
 * @author marius orcisk <marius@habarnam.ro>
 * @date 2010.12.05
 */

class vscControllerMap extends vscMappingA implements vscContentTypeMappingI {
	private $sMainTemplatePath;
	private $sMainTemplate;

	private $sViewPath;

	public function setMainTemplatePath ($sPath) {
		$this->sMainTemplatePath = realpath($sPath);
	}

	public function getMainTemplatePath () {
		// if we didn't provide the controller with a main template path we check the module
		if ( is_null($this->sMainTemplatePath)) {
			if ( $this->getModuleMap() instanceof vscContentTypeMappingI) {
				$this->sMainTemplatePath = $this->getModuleMap()->getMainTemplatePath();
			}
		}

		if ( is_null($this->sMainTemplatePath)) {
			// back-up
			$this->sMainTemplatePath = VSC_RES_PATH . 'templates';
		}
		return $this->sMainTemplatePath;
	}

	public function setMainTemplate ($sPath) {
		$this->sMainTemplate = $sPath;
	}

	public function getMainTemplate () {
		// if we didn't provide the controller with a main template path we check the module
		if ( is_null($this->sMainTemplate ) ) {
			if ( $this->getModuleMap() instanceof vscContentTypeMappingI) {
				$this->sMainTemplate = $this->getModuleMap()->getMainTemplate();
			}
		}
		if ( is_null($this->sMainTemplate)) {
			// back-up
			$this->sMainTemplate = 'main.php';
		}
		return $this->sMainTemplate;
	}

	/**
	 *
	 * To allow a single controller type to return a different type of view
	 * @param string $sPath
	 */
	public function setView ($sPath) {
		if (vscSiteMapA::isValidObject($sPath)) {
			$this->sViewPath = $sPath;
		} else {
			throw new vscExceptionPath ('View path ['.$sPath.'] is not valid.');
		}
	}

	public function getViewPath(){
		return $this->sViewPath;
	}
}
