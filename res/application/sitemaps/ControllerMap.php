<?php
/**
 * @package application
 * @subpackage sitemaps
 * @author marius orcisk <marius@habarnam.ro>
 * @date 2010.12.05
 */
namespace vsc\application\sitemaps;

use vsc\ExceptionPath;
use vsc\presentation\views\ViewA;

class ControllerMap extends MappingA implements ContentTypeMappingI {
	private $sMainTemplatePath;
	private $sMainTemplate;

	private $sViewPath;
	private $oView;

	public function setMainTemplatePath ($sPath) {
		$this->sMainTemplatePath = realpath($sPath);
		if ( !is_dir($this->sMainTemplatePath) ) {
			$this->sMainTemplatePath = null;
			throw new ExceptionPath (sprintf('Path [%s] does not exist', $sPath));
		}
	}

	public function getMainTemplatePath () {
		// if we didn't provide the controller with a main template path we check the module
		if ( is_null($this->sMainTemplatePath)) {
			if ( $this->getModuleMap() instanceof ContentTypeMappingI) {
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
			if ( $this->getModuleMap() instanceof ContentTypeMappingI) {
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
	 * @throws ExceptionPath
	 */
	public function setView ($mView) {
		if (ViewA::isValid($mView)) {
			$this->oView = $mView;
		} elseif (stristr(basename($mView), '.') === false && !is_file($mView)) {
			// namespaced class name
			$this->sViewPath = $mView;
		} elseif (SiteMapA::isValidObject($mView)) {
			$this->sViewPath = $mView;
		} else {
			throw new ExceptionPath ('View path [' . $mView . '] is not valid.');
		}
	}

	public function getViewPath() {
		return $this->sViewPath;
	}

	public function getView() {
		if ( !ViewA::isValid($this->oView) && !is_null($this->sViewPath)){
			if (stristr(basename($this->sViewPath), '.') === false && !is_file($this->sViewPath)) {
				$sClassName = $this->sViewPath;
			} elseif (is_file($this->sViewPath)) {
				$sViewPath = $this->getViewPath();
				try {
					include ($sViewPath);
				} catch (\Exception $e) {
					\vsc\_e($e);
				}
				$sClassName = SiteMapA::getClassName($sViewPath);
			}
		}
		if (!empty($sClassName)) {
			$this->oView = new $sClassName();
		}
		return $this->oView;
	}
}
