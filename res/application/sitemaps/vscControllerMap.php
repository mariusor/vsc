<?php
/**
 * @package vsc_application
 * @subpackage sitemaps
 * @author marius orcisk <marius@habarnam.ro>
 * @date 2010.12.05
 */
namespace vsc\application\sitemaps;

use vsc\vscExceptionPath;
use vsc\presentation\views\vscViewA;

class vscControllerMap extends vscMappingA implements vscContentTypeMappingI {
	private $sMainTemplatePath;
	private $sMainTemplate;

	private $sViewPath;
	private $oView;

	public function setMainTemplatePath ($sPath) {
		$this->sMainTemplatePath = realpath($sPath);
		if ( !is_dir($this->sMainTemplatePath) ) {
			$this->sMainTemplatePath = null;
			throw new vscExceptionPath (sprintf('Path [%s] does not exist', $sPath));
		}
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
	 * @param string|object $mView
	 * @throws vscExceptionPath
	 */
	public function setView ($mView) {
		if (vscViewA::isValid($mView)) {
			$this->oView = $mView;
		} elseif (stristr(basename($mView), '.') === false && !is_file($mView)) {
			// namespaced class name
			$this->sViewPath = $mView;
		} elseif (vscSiteMapA::isValidObject($mView)) {
			$this->sViewPath = $mView;
		} else {
			throw new vscExceptionPath ('View path [' . $mView . '] is not valid.');
		}
	}

	public function getViewPath() {
		return $this->sViewPath;
	}

	public function getView() {
		if ( !vscViewA::isValid($this->oView) && !is_null($this->sViewPath)){
			if (stristr(basename($this->sViewPath), '.') === false && !is_file($this->sViewPath)) {
				$sClassName = $this->sViewPath;
			} elseif (is_file($this->sViewPath)) {
				$sViewPath = $this->getViewPath();
				try {
					include ($sViewPath);
				} catch (\Exception $e) {
					_e($e);
				}
				$sClassName = vscSiteMapA::getClassName($sViewPath);
			}
		}
		if (!empty($sClassName)) {
			$this->oView = new $sClassName();
		}
		return $this->oView;
	}
}
