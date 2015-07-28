<?php
namespace vsc\application\sitemaps;

use vsc\ExceptionPath;
use vsc\presentation\views\ViewA;

trait ControllerMapT {
	private $sMainTemplatePath;
	private $sMainTemplate;

	private $sViewPath;
	private $oView;

	/**
	 * @return ModuleMap
	 */
	abstract public function getModuleMap();

	/**
	 * @param string $sPath
	 * @return bool
	 * @throws \vsc\ExceptionPath
	 */
	public function setMainTemplatePath($sPath) {
		$sMainTemplatePath = realpath($sPath);
		if (!is_dir($sMainTemplatePath)) {
			$sMainTemplatePath = realpath($this->getModuleMap()->getModulePath() . DIRECTORY_SEPARATOR . $sPath);
		}
		if (!is_dir($sMainTemplatePath)) {
			throw new ExceptionPath(sprintf('Path [%s] does not exist', $sPath));
		}
		$this->sMainTemplatePath = $sMainTemplatePath;

		return true;
	}

	/**
	 * @return string
	 */
	public function getMainTemplatePath() {
		// if we didn't provide the controller with a main template path we check the module
		if (is_null($this->sMainTemplatePath)) {
			if ($this->getModuleMap() instanceof ContentTypeMappingI) {
				$this->sMainTemplatePath = $this->getModuleMap()->getMainTemplatePath();
			}
		}

		if (is_null($this->sMainTemplatePath)) {
			// back-up
			$this->sMainTemplatePath = VSC_RES_PATH . 'templates';
		}
		if (substr($this->sMainTemplatePath, -1) != DIRECTORY_SEPARATOR) {
			$this->sMainTemplatePath .= DIRECTORY_SEPARATOR;
		}
		return $this->sMainTemplatePath;
	}

	/**
	 * @param string $sPath
	 */
	public function setMainTemplate($sPath) {
		$this->sMainTemplate = $sPath;
	}

	/**
	 * @return string
	 */
	public function getMainTemplate() {
		// if we didn't provide the controller with a main template path we check the module
		if (is_null($this->sMainTemplate)) {
			if ($this->getModuleMap() instanceof ContentTypeMappingI) {
				$this->sMainTemplate = $this->getModuleMap()->getMainTemplate();
			}
		}
		if (is_null($this->sMainTemplate)) {
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
	public function setView($mView) {
		if (ViewA::isValid($mView)) {
			$this->oView = $mView;
			$this->sViewPath = get_class($mView);
		} elseif (stristr(basename($mView), '.') === false && !is_file($mView)) {
			// namespaced class name
			$this->sViewPath = $mView;
		} elseif (SiteMapA::isValidObjectPath($mView)) {
			$this->sViewPath = $mView;
		} else {
			throw new ExceptionPath('View path [' . $mView . '] is not valid.');
		}
	}

	public function getViewPath() {
		return $this->sViewPath;
	}

	public function getView() {
		if (!ViewA::isValid($this->oView) && !is_null($this->sViewPath)) {
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
