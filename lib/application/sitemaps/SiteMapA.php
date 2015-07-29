<?php
/**
 * @package application
 * @subpackage sitemaps
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.09.24
 */
namespace vsc\application\sitemaps;

use vsc\application\processors\ProcessorA;
use vsc\infrastructure\Object;

abstract class SiteMapA extends Object {
	/**
	 * the base regex for the current map
	 * @todo this needs to be deprecated in favour of regexes of the parent module
	 * @var string
	 */
	private $aMaps = array();
	/**
	 * @var ModuleMap
	 */
	private $oCurrentModuleMap;

	public function __construct() {}

	/**
	 * @return string
	 */
	public function getBaseRegex() {
		$oModuleMap = $this->getCurrentModuleMap();
		if (ModuleMap::isValid($oModuleMap)) {
			return (string)$oModuleMap->getRegex();
		}
		return null;
	}

	/**
	 *
	 * @param string $sRegex
	 * @param string $sPath
	 * @returns MappingA
	 */
	public function addMap($sRegex, $sPath) {
		$oModuleMap = $this->getCurrentModuleMap();

		if (MappingA::isValid($oModuleMap)) {
			$sRegex = $oModuleMap->getRegex() . $sRegex;
		}

		if (!array_key_exists($sRegex, $this->aMaps)) {
			$oNewMap = new ClassMap($sPath, $sRegex);

			if (MappingA::isValid($oModuleMap)) {
				$oNewMap->merge($oModuleMap);
				$oNewMap->setModuleMap($oModuleMap);
			}

			$this->aMaps[$sRegex] = $oNewMap;
		} else {
			$oNewMap = $this->aMaps[$sRegex];
		}

		return $oNewMap;
	}

	/**
	 * @param string $sRegex
	 * @param string $sPath
	 * @throws ExceptionSitemap
	 * @returns MappingA
	 */
	protected function addClassMap($sRegex, $sPath) {
		$oModuleMap = $this->getCurrentModuleMap();
		$oNewMap = null;

		if (MappingA::isValid($oModuleMap)) {
			$sRegex = $oModuleMap->getRegex() . $sRegex;
		}

		if (!array_key_exists($sRegex, $this->aMaps)) {
			$oNewMap = new ClassMap($sPath, $sRegex);

			if (MappingA::isValid($oModuleMap)) {
				$oNewMap->merge($oModuleMap);
				$oNewMap->setModuleMap($oModuleMap);
			}

			$this->aMaps[$sRegex] = $oNewMap;
		}
		return $oNewMap;
	}

	/**
	 *
	 * @param string $sRegex
	 * @param string $sPath
	 * @returns MappingA
	 */
	public function addModuleMap($sRegex, $sPath) {
		$oModuleMap = $this->getCurrentModuleMap();

		// setting the parent module map to the existing one
		if (MappingA::isValid($oModuleMap)) {
			$sRegex = $oModuleMap->getRegex() . $sRegex;

			$oNewModuleMap = new ModuleMap($sPath, $sRegex);

			$oNewModuleMap->setModuleMap($oModuleMap);
			$oNewModuleMap->merge($oModuleMap);
		} else {
			$oNewModuleMap = new ModuleMap($sPath, $sRegex);
		}

		// switching the current module map to the new one
		$this->oCurrentModuleMap = $oNewModuleMap;

		include ($sPath);

		if (ModuleMap::isValid($oNewModuleMap->getModuleMap())) {
			// 	after we finished parsing the new module, we set the previous module map as current
			$this->oCurrentModuleMap = $oNewModuleMap->getModuleMap();
		}

		return $oNewModuleMap;
	}

	/**
	 *
	 * @param string $sRegex
	 * @param string $sPath
	 * @returns MappingA
	 */
	public function addStaticMap($sRegex, $sPath) {
		$oStaticMap = $this->addMap($sRegex, $sPath);
		$oStaticMap->setIsStatic(true);
		return $oStaticMap;
	}

	/**
	 * @returns ClassMap[]
	 */
	public function getMaps() {
		return $this->aMaps;
	}

	/**
	 * This tells us if $sPath belongs to a file that can be used as a static resource
	 *  eg. Javascript, CSS, etc.
	 * @param string $sPath
	 * @return bool
	 */
	public static function isValidStaticPath($sPath) {
		return (!stristr($sPath, 'php') && is_file($sPath));
	}

	/**
	 * verifies if $sPath is on the path
	 * verifies if $sPath is a valid folder and it has a config/map.php file
	 * @param string $sPath
	 * @return bool
	 */
	public static function isValidMapPath($sPath) {
		return (basename($sPath) == 'map.php' && is_file($sPath));
	}

	public static function isValidObjectPath($sPath) {
		return (substr($sPath, -4) == '.php' && is_file($sPath));
	}

	/**
	 * Gets the class name of based on the included path
	 * In order for it to work the file needs to be already include()-d
	 * @param string $sPath
	 * @return string
	 */
	public static function getClassName($sPath) {
		$sClassName = strtolower(basename($sPath, '.php'));

		$iKey = array_search($sClassName, array_map('strtolower', get_declared_classes()));
		$aClasses = get_declared_classes();

		return  $aClasses[$iKey];
	}

	/**
	 * @returns ModuleMap
	 */
	public function getCurrentModuleMap() {
		return $this->oCurrentModuleMap;
	}

	/**
	 * @return MappingA|null
	 */
	public function getParentModuleMap() {
		if (MappingA::isValid($this->oCurrentModuleMap)) {
			$oParentModule = $this->oCurrentModuleMap->getModuleMap();
			if (ModuleMap::isValid($oParentModule)) {
				return $oParentModule;
			}
		}
		// return a default root node
		return new ModuleMap(VSC_RES_PATH . 'config/map.php', '');
	}

	/**
	 *
	 * @param string $sRegex
	 * @param string $sPath
	 * @throws ExceptionSitemap
	 * @returns MappingA
	 */
	public function map($sRegex, $sPath) {
		if ($sRegex === null) {
			throw new ExceptionSitemap('A regex URI must be present.');
		}
		if (empty($sPath)) {
			throw new ExceptionSitemap('A path must be present.');
		}

		if (class_exists($sPath)) {
			// instead of a path we have a namespace
			return $this->addClassMap($sRegex, $sPath);
		} else {
			if (!is_file($sPath)) {
				$sPath = $this->getCurrentModuleMap()->getModulePath() . $sPath;
			}

			if (!is_file($sPath)) {
				throw new ExceptionSitemap('The path associated with [' . $sRegex . '] can\'t be empty or an invalid file.');
			}

			$sPath = str_replace(array('/', '\\'), array(DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR), $sPath);
			if (ModuleMap::isValidMap($sPath)) {
				// Valid site map
				return $this->addModuleMap($sRegex, $sPath);
			}
			if (ClassMap::isValidMap($sPath)) {
				// Valid processor
				return $this->addMap($sRegex, $sPath);
			}
			if (self::isValidStaticPath($sPath)) {
				// Valid static file
				return $this->addStaticMap($sRegex, $sPath);
			}
			throw new ExceptionSitemap('The file [' . $sPath . '] could not be loaded.');
		}
	}

	/**
	 * @returns ModuleMap[]
	 */
	protected function getAllModules() {
		$aProcessorMaps = $this->getMaps();
		$aModuleMaps = array();

		/* @var MappingA $oProcessor */
		foreach ($aProcessorMaps as $sKey => $oProcessor) {
			$oModuleMap = $oProcessor->getModuleMap();
			if (!in_array($oModuleMap, $aModuleMaps, true)) {
				$aModuleMaps[$oModuleMap->getRegex()] = $oModuleMap;
			}

		}

		return $aModuleMaps;
	}

	/**
	 * @returns ClassMap[]
	 */
	protected function getAllControllers() {
		$aProcessorMaps = $this->getMaps();
		$aControllerMaps = array();

		/* @var MappingA $oProcessor */
		foreach ($aProcessorMaps as $oProcessor) {
			$aControllerMaps = array_merge($aControllerMaps, $oProcessor->getModuleMap()->getControllerMaps());
		}

		return $aControllerMaps;
	}

	public function getControllerMappings() {
		$aC = false;
		foreach ($this->getAllControllers() as $sKey => $oController) {
			$aC[$sKey] = $oController->getPath();
		}
		return $aC;
	}

	public function getModuleMappings() {
		$aC = false;
		foreach ($this->getAllModules() as $sKey => $oModule) {
			$aC[$sKey] = $oModule->getPath();
		}
		return $aC;
	}

	/**
	 * @returns ClassMap[]
	 */
	public function getProcessorMappings() {
		$aC = false;
		foreach ($this->getMaps() as $sKey => $oProcessor) {
			$aC[$sKey] = $oProcessor->getPath();
		}
		return $aC;
	}

	/**
	 * @param ProcessorA $oProcessor
	 * @return MappingA
	 */
	public function findProcessorMap(ProcessorA $oProcessor) {
		/* @var ClassMap $oProcessorMap */
		foreach ($this->getMaps() as $oProcessorMap) {
			if ($oProcessorMap->maps($oProcessor)) {
				return $oProcessorMap;
			}
		}
		return null;
	}
}
