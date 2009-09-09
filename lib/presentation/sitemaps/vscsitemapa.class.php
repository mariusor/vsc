<?php
/**
 * @package vsc_presentation
 * @subpackage sitemaps
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.30
 */
abstract class vscSiteMapA {
	private $aBasePath;
	private $aMaps;
	private $aModules;
	private $sCurrentModule;

	static public function getLibProcessorPath () {
		return realpath(dirname(__FILE__) . '/..') . DIRECTORY_SEPARATOR;
	}

	public function __construct () {
		$oModule = new vscMappingModule ();
		$oModule->setName ('processors');
		$oModule->setParent (null);
		$oModule->setPath (self::getLibProcessorPath());

		$this->aModules['processors']	= $oModule;
		$this->sCurrentModule = 'processors';
	}

	public function setBasePath ($sPath) {
		if (!$sPath || !is_dir ($sPath)) {
			throw new vscExceptionModuleImport ('The base module path [' . ($sPath). '] is invalid.');
		}

		$this->aBasePath  = realpath($sPath) . DIRECTORY_SEPARATOR;
	}

	/**
	 * @param $sModuleName
	 * @return vscMappingModule
	 */
	public function getModule ($sModuleName) {
		if (isset ($this->aModules[$sModuleName]))
			return $this->aModules[$sModuleName];
		return false;
	}

	public function getCurrentModulePath() {
		if (!$this->getCurrentModule()) {
			$sPath = $this->getBasePath();
		} else {
			$sPath = $this->getCurrentModule()->getPath();
		}

		return $sPath;
	}

	public function getCurrentModuleUrl () {
		if (!$this->getCurrentModule()) {
			$sUrl = '';
		} else {
			$sUrl = $this->getCurrentModule()->getUrl();
		}

		return $sUrl;
	}

	public function getBasePath () {
		return $this->aBasePath;
	}

	public function getMaps () {
		return $this->aMaps;
	}

//	abstract public function getMappedProcessor ($sUrl);

	public function mapProcessor ($sRegex, $sProcessorName) {}

	/**
	 * if #isValidModule adds the sModuleName to the include path
	 * includes the sitemap located at sModuleName/config/map.php
	 * @param string $sRegex
	 * @param string $sModuleName
	 * @return void
	 */
	public function mapModule ($sRegex, $sModuleName) {
		if (!$this->getModule($sModuleName)) {
			$oModule = new vscMappingModule ($this->getCurrentModuleUrl() . $sRegex, $this->getCurrentModulePath() . $sModuleName);
			$oModule->setName ($sModuleName);
			$oModule->setParent($this->getCurrentModule() ? $this->getCurrentModule()->getName() : '.');
		}
		if ($this->isValidModule ($sModuleName)) {
			// setting the new module as the current one
			$this->sCurrentModule = $sModuleName;
			try {
				$this->aModules[$sModuleName]	= $oModule;
//				include ($this->getModule($sModuleName)->getConfigMap());
			} catch (Exception $e) {
				// oops
				throw $e;
			}
		} else {
			throw new vscExceptionModuleImport('Bad, module ['. $sModuleName .']');
		}
		// setting the parent as the current module
		$this->sCurrentModule = $oModule->getParent();
	}

	/**
	 * @return vscMappingModule
	 */
	private function getCurrentModule () {
		return $this->getModule ($this->sCurrentModule);
	}

	/**
	 * verifies if sModuleName is on the path
	 * verifies if sModuleName is a valid folder and it has a config/map.php file
	 * @param string $sModuleName
	 * @return bool
	 */
	private function isValidModule ($sModuleName) {
		if (is_dir ($this->getCurrentModulePath() . $sModuleName)) {
			return true;
		}
		return false;
	}

	protected function isValidProcessor ($sProcessorName) {
		return (is_file ($this->getCurrentModule()->getProcessorPath()) . strtolower($sProcessorName) . '.class.php');
	}

	public function map ($sRegex, $sProcessorName) {
		d ($sRegex, $sProcessorName);
		try {
		if (!$sRegex) {
			throw new vscExceptionSitemap ('An path must be present.');
		}
		if (!$sProcessorName || !$this->isValidProcessor ($sProcessorName)) {
			throw new vscExceptionSitemap ('The controller [' . ($sProcessorName). '] could not be resolved.');
		}
		} catch (Exception $e) {
			d ($e);
		}
		$sProcessorFile = strtolower($sProcessorName) . '.class.php';
		$sProcessorPath = $this->getCurrentModule()->getProcessorPath() . $sProcessorFile;
		$oProcessorMapping = new vscMappingProcessor($this->getCurrentModule()->getUrl(). $sRegex, $sProcessorPath);
		$oProcessorMapping->setName ($sProcessorName);

		$this->aMaps[$sRegex] = $oProcessorMapping;
	}

	public function getAllMaps () {
		return $this->aMaps;
	}
}
