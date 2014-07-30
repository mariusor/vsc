<?php
/**
 * @package vsc_application
 * @subpackage sitemaps
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.09.24
 */
namespace vsc\application\sitemaps;

use vsc\application\controllers\vscFrontControllerA;
use vsc\application\processors\vscProcessorA;
use vsc\infrastructure\vscNull;
use vsc\infrastructure\vscObject;

abstract class vscSiteMapA extends vscObject {
	/**
	 * the base regex for the current map
	 * @todo this needs to be deprecated in favour of regexes of the parent module
	 * @var string
	 */
	private $aMaps = array();
	/**
	 * @var vscModuleMap
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
	 * @return vscMappingA
	 */
	public function addMap ($sRegex, $sPath) {
		$oModuleMap = $this->getCurrentModuleMap();

		if (vscMappingA::isValid($oModuleMap)) {
			$sRegex = $oModuleMap->getRegex() . $sRegex;
		}

		if (!array_key_exists($sRegex, $this->aMaps)) {
			$oNewMap 	= new vscProcessorMap($sPath, $sRegex);

			if (vscMappingA::isValid($oModuleMap)) {
				$oNewMap->merge($oModuleMap);
				$oNewMap->setModuleMap($oModuleMap);
			}

//			if (stristr($sRegex, 'comics')) d ($oNewMap);
			$this->aMaps[$sRegex] = $oNewMap;
			return $oNewMap;
		}
//		throw new vscExceptionSitemap('Regular expression exists already in the list of URLs');
	}

	/**
	 *
	 * @param string $sRegex
	 * @param string $sPath
	 * @return vscMappingA
	 */
	public function addModuleMap ($sRegex, $sPath) {
		$oModuleMap	= $this->getCurrentModuleMap();

		// setting the parent module map to the existing one
		if (vscMappingA::isValid($oModuleMap)) {
			$sRegex				= $oModuleMap->getRegex() . $sRegex;

			$oNewModuleMap		= new vscModuleMap($sPath, $sRegex);

			$oNewModuleMap->setModuleMap($oModuleMap);
			$oNewModuleMap->merge($oModuleMap);
		} else {
			$oNewModuleMap		= new vscModuleMap($sPath, $sRegex);
		}

		// switching the current module map to the new one
		$this->oCurrentModuleMap = $oNewModuleMap;

		include ($sPath);

		if (vscModuleMap::isValid($oNewModuleMap->getModuleMap())) {
			// 	after we finished parsing the new module, we set the previous module map as current
			$this->oCurrentModuleMap = $oNewModuleMap->getModuleMap();
		}

		return $oNewModuleMap;
	}

	/**
	 *
	 * @param string $sRegex
	 * @param string $sPath
	 * @return vscMappingA
	 */
	public function addStaticMap ($sRegex, $sPath) {
		$oStaticMap = $this->addMap ($sRegex, $sPath);
		$oStaticMap->setIsStatic(true);
		return $oStaticMap;

	}

	/**
	 * @return vscProcessorMap[]
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
		return (substr ($sPath, -10) == '.class.php' && is_file ($sPath));
	}

	/**
	 * Gets the class name of based on the included path
	 * In order for it to work the file needs to be already include()-d
	 * @param string $sPath
	 * @return string
	 */
	static public function getClassName ($sPath) {
		$sClassName	= basename($sPath, '.class.php');
		$iKey		= array_search($sClassName, array_map('strtolower', get_declared_classes()));
		$aClasses	= get_declared_classes();

		return  $aClasses[$iKey];
	}

	/**
	 * @return vscMappingA
	 */
	public function getCurrentModuleMap () {
		if (vscMappingA::isValid($this->oCurrentModuleMap)) {
			return $this->oCurrentModuleMap;
		} else {
			return new vscNull();
		}
	}

	public function getParentModuleMap () {
		if (vscMappingA::isValid($this->oCurrentModuleMap)) {
			return $this->oCurrentModuleMap->getModuleMap();
		}
	}

	/**
	 *
	 * @param string $sRegex
	 * @param string $sPath
	 * @throws vscExceptionSitemap
	 * @return vscMappingA
	 */
	public function map ($sRegex, $sPath) {
		if ($sRegex === null) {
			throw new vscExceptionSitemap ('A regex URI must be present.');
		}
		if (!empty($sPath)) {
			if (!is_file($sPath)) {
				$sPath = $this->getCurrentModuleMap()->getModulePath() . $sPath;
			}
		}

		if (!is_file($sPath)) {
			throw new vscExceptionSitemap ('The path associated with ['.$sRegex.'] can\'t be empty or an invalid file.');
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

		throw new vscExceptionSitemap('The file ['.$sPath.'] could not be loaded.');
	}

	/**
	 * @return vscModuleMap[]
	 */
	private function getAllModules () {
		$aProcessorMaps = $this->getMaps();
		$aModuleMaps = array();

		/* @var $oProcessor vscMappingA */
		foreach ($aProcessorMaps as $sKey => $oProcessor) {
			$oModuleMap = $oProcessor->getModuleMap();
			if (!in_array($oModuleMap, $aModuleMaps, true)) {
				$aModuleMaps[$oModuleMap->getRegex()] = $oModuleMap;
			}

		}

		return $aModuleMaps;
	}

	/**
	 * @return vscControllerMap[]
	 */
	private function getAllControllers () {
		$aProcessorMaps = $this->getMaps();
		$aControllerMaps = array();

		/* @var $oProcessor vscMappingA */
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
	 * @return vscProcessorMap[]
	 */
	public function getProcessorMappings () {
		foreach($this->getMaps() as $sKey => $oProcessor) {
			$aC[$sKey] = $oProcessor->getPath();
		}
		return $aC;
	}

	public function findProcessorMap (vscProcessorA $oProcessor) {
		$sNameLower = strtolower(get_class($oProcessor));

		/* @var $oProcessorMap vscProcessorMap */
		foreach ($this->getMaps() as $sRegex => $oProcessorMap ) {
			if (stristr($oProcessorMap->getPath(), $sNameLower)) {
				return $oProcessorMap;
			}
		}
	}
}
