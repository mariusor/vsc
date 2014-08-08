<?php
/**
 * @package application
 * @subpackage sitemaps
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.09.24
 */
namespace vsc\application\sitemaps;

use vsc\application\controllers\FrontControllerA;
use vsc\application\processors\ProcessorA;
use vsc\infrastructure\Null;
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

	public function __construct () {}

	/**
	 * @return string
	 */
	public function getBaseRegex () {
		return (string)$this->getCurrentModuleMap()->getRegex();
	}

	/**
	 *
	 * @param string $sRegex
	 * @param string $sPath
	 * @returns MappingA
	 */
	public function addMap ($sRegex, $sPath) {
		$oModuleMap = $this->getCurrentModuleMap();

		if (MappingA::isValid($oModuleMap)) {
			$sRegex = $oModuleMap->getRegex() . $sRegex;
		}

		if (!array_key_exists($sRegex, $this->aMaps)) {
			$oNewMap 	= new ProcessorMap($sPath, $sRegex);

			if (MappingA::isValid($oModuleMap)) {
				$oNewMap->merge($oModuleMap);
				$oNewMap->setModuleMap($oModuleMap);
			}

//			if (stristr($sRegex, 'comics')) d ($oNewMap);
			$this->aMaps[$sRegex] = $oNewMap;
			return $oNewMap;
		}
//		throw new ExceptionSitemap('Regular expression exists already in the list of URLs');
	}

	/**
	 * @param string $sRegex
	 * @param string $sPath
	 * @throws ExceptionSitemap
	 * @returns MappingA
	 */
	protected function addClassMap($sRegex, $sPath) {
		$oModuleMap = $this->getCurrentModuleMap();
		$oNewMap 	= null;

		if (MappingA::isValid($oModuleMap)) {
			$sRegex = $oModuleMap->getRegex() . $sRegex;
		}

		if (!array_key_exists($sRegex, $this->aMaps)) {
			$oNewMap 	= new ClassMap($sPath, $sRegex);

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
	public function addModuleMap ($sRegex, $sPath) {
		$oModuleMap	= $this->getCurrentModuleMap();

		// setting the parent module map to the existing one
		if (MappingA::isValid($oModuleMap)) {
			$sRegex				= $oModuleMap->getRegex() . $sRegex;

			$oNewModuleMap		= new ModuleMap($sPath, $sRegex);

			$oNewModuleMap->setModuleMap($oModuleMap);
			$oNewModuleMap->merge($oModuleMap);
		} else {
			$oNewModuleMap		= new ModuleMap($sPath, $sRegex);
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
	public function addStaticMap ($sRegex, $sPath) {
		$oStaticMap = $this->addMap ($sRegex, $sPath);
		$oStaticMap->setIsStatic(true);
		return $oStaticMap;
	}

	/**
	 * @returns ProcessorMap[]
	 */
	public function getMaps () {
		return $this->aMaps;
	}

	/**
	 * @param $sPath
	 * @return bool
	 */
	static public function isValidStatic ($sPath) {
		return (is_file ($sPath) && !stristr($sPath, 'php'));
	}

	/**
	 * verifies if $sPath is on the path
	 * verifies if $sPath is a valid folder and it has a config/map.php file
	 * @param string $sPath
	 * @return bool
	 */
	static public function isValidMap ($sPath) {
		return (basename ($sPath) == 'map.php' && is_file ($sPath));
	}

	static public function isValidObject ($sPath) {
		return (substr ($sPath, -4) == '.php' && is_file ($sPath));
	}

	/**
	 * Gets the class name of based on the included path
	 * In order for it to work the file needs to be already include()-d
	 * @param string $sPath
	 * @return string
	 */
	static public function getClassName ($sPath) {
		$sClassName	= basename($sPath, '.php');
//		$sClassName	= substr($sPath, 0, -4);

		$iKey		= array_search($sClassName, array_map('strtolower', get_declared_classes()));
		$aClasses	= get_declared_classes();

		return  $aClasses[$iKey];
	}

	/**
	 * @returns MappingA
	 */
	public function getCurrentModuleMap () {
		if (MappingA::isValid($this->oCurrentModuleMap)) {
			return $this->oCurrentModuleMap;
		} else {
			return new Null();
		}
	}

	public function getParentModuleMap () {
		if (MappingA::isValid($this->oCurrentModuleMap)) {
			return $this->oCurrentModuleMap->getModuleMap();
		}
	}

	/**
	 *
	 * @param string $sRegex
	 * @param string $sPath
	 * @throws ExceptionSitemap
	 * @returns MappingA
	 */
	public function map ($sRegex, $sPath) {
		if ($sRegex === null) {
			throw new ExceptionSitemap ('A regex URI must be present.');
		}
		if (empty($sPath)) {
			throw new ExceptionSitemap ('A path must be present.');
		}

		if ( stristr(basename($sPath), '.') === false && !is_file($sPath)) {
			// instead of a path we have a namespace
			return $this->addClassMap($sRegex, $sPath);
		} else {
			if  (!is_file($sPath)) {
				$sPath = $this->getCurrentModuleMap()->getModulePath() . $sPath;
			}

			if (!is_file($sPath)) {
				throw new ExceptionSitemap ('The path associated with [' . $sRegex . '] can\'t be empty or an invalid file.');
			}

			$sPath = str_replace(array('/','\\'), array(DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR),$sPath);
			if (self::isValidMap ($sPath)) {
				// Valid site map
				return $this->addModuleMap($sRegex, $sPath);
			} elseif (self::isValidObject ($sPath)) {
				// Valid processor
				return $this->addMap ($sRegex, $sPath);
			} elseif (self::isValidStatic($sPath)) {
				// Valid static file
				return $this->addStaticMap ($sRegex, $sPath);
			}
			throw new ExceptionSitemap('The file [' . $sPath . '] could not be loaded.');
		}
	}

	/**
	 * @returns ModuleMap[]
	 */
	private function getAllModules () {
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
	 * @returns ControllerMap[]
	 */
	private function getAllControllers () {
		$aProcessorMaps = $this->getMaps();
		$aControllerMaps = array();

		/* @var MappingA $oProcessor */
		foreach ($aProcessorMaps as $oProcessor) {
			$aControllerMaps = array_merge($aControllerMaps, $oProcessor->getModuleMap()->getControllerMaps());
		}

		return $aControllerMaps;
	}

	public function getControllerMappings () {
		foreach($this->getAllControllers() as $sKey => $oController) {
			$aC[$sKey] = $oController->getPath();
		}
		return $aC;
	}

	public function getModuleMappings () {
		foreach($this->getAllModules() as $sKey => $oModule) {
			$aC[$sKey] = $oModule->getPath();
		}
		return $aC;
	}

	/**
	 * @returns ProcessorMap[]
	 */
	public function getProcessorMappings () {
		foreach($this->getMaps() as $sKey => $oProcessor) {
			$aC[$sKey] = $oProcessor->getPath();
		}
		return $aC;
	}

	public function findProcessorMap (ProcessorA $oProcessor) {
		$sNameLower = strtolower(get_class($oProcessor));

		/* @var ProcessorMap $oProcessorMap */
		foreach ($this->getMaps() as $sRegex => $oProcessorMap ) {
			if (stristr($oProcessorMap->getPath(), $sNameLower)) {
				return $oProcessorMap;
			}
		}
	}
}
