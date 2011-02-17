<?php
/**
 * @package vsc_application
 * @subpackage sitemaps
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.09.24
 */
abstract class vscSiteMapA extends vscObject {
	/**
	 * the base regex for the current map
	 * @todo this needs to be deprecated in favour of regexes of the parent module
	 * @var string
	 */
	private $aMaps = array();
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

		if ($oModuleMap instanceof vscMappingA) {
			$sRegex = $oModuleMap->getRegex() . $sRegex;
		}

		if (!key_exists($sRegex, $this->aMaps)) {
			$oNewMap 	= new vscProcessorMap($sPath, $sRegex);

			if ($oModuleMap instanceof vscMappingA) {
				$oNewMap->merge($oModuleMap);
				$oNewMap->setModuleMap($oModuleMap);
			}

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
		if ($oModuleMap instanceof vscMappingA) {
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

		// 	after we finished parsing the new module, we set the previous module map as current
		$this->oCurrentModuleMap = $oModuleMap;

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
	 * @return array
	 */
	public function getMaps () {
		return $this->aMaps;
	}

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

	public function getClassName ($sPath) {
		$sClassName	= substr(basename($sPath), 0, -10); // strlen('.class.php')
		$iKey		= array_search($sClassName, array_map('strtolower', get_declared_classes()));
		$aClasses	= get_declared_classes();
		return  $aClasses[$iKey];
	}

	/**
	 * @return vscMappingA
	 */
	public function getCurrentModuleMap () {
		if ($this->oCurrentModuleMap instanceof vscMappingA) {
			return $this->oCurrentModuleMap;
		} else {
			return new vscNull();
		}
	}

	public function getParentModuleMap () {
		if ($this->oCurrentModuleMap instanceof vscMappingA) {
			return $this->oCurrentModuleMap->getModuleMap();
		}
	}

	/**
	 *
	 * @param string $sRegex
	 * @param string $sPath
	 * @return vscMappingA
	 */
	public function map ($sRegex, $sPath) {
		if ($sRegex === null) {
			throw new vscExceptionSitemap ('A regex URI must be present.');
		}
		if (empty($sPath) || !is_file($sPath)) {
			throw new vscExceptionSitemap ('The path associated with ['.$sRegex.'] can\'t be empty or an invalid file.');
		}

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

	private function getAllModules () {
		$aProcessorMaps = $this->getMaps();
		$aModuleMaps = array();

		/* @var $oProcessor vscMappingA */
		foreach ($aProcessorMaps as $sKey => $oProcessor) {
			$aModuleMaps[$sKey] = $oProcessor->getModuleMap();
		}

		return $aModuleMaps;
	}

	private function getAllControllers () {
		$aProcessorMaps = $this->getMaps();
		$aControllerMaps = array();

		/* @var $oProcessor vscMappingA */
		foreach ($aProcessorMaps as $oProcessor) {
			$aControllerMaps = array_merge($aControllerMaps, $oProcessor->getModuleMap()->getControllerMaps());
		}

		return $aControllerMaps;
	}
}
