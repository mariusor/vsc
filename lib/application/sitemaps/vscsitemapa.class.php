<?php
/**
 * @package vsc_application
 * @subpackage sitemaps
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.09.24
 */
abstract class vscSiteMapA extends vscObject {
	private $aBasePath;
	private $aMaps;
	private $aControllerMaps;

	public function __construct () {}

	/**
	 * @param string $sPath
	 * @return void
	 */
	public function setBasePath ($sPath) {
		$this->aBasePath = $sPath;
	}

	/**
	 * @return string
	 */
	public function getBasePath () {
		return $this->aBasePath;
	}

	/**
	 *
	 * @param string $sRegex
	 * @param string $sPath
	 * @return vscMapping
	 */
	public function addMap ($sRegex, $sPath) {
		$sKey = $this->getBasePath() . $sRegex;
		if (!is_array($this->aMaps) || !key_exists($sKey, $this->aMaps)) {
			$oNewMap 	= new vscMapping($sPath, $sKey);
			if (key_exists ('__map', $GLOBALS) && $GLOBALS['__map'] instanceof vscMapping) {
				$oNewMap->merge($GLOBALS['__map']);
			}
			$this->aMaps[$sKey] = $oNewMap;
			return $oNewMap;
		}
	}

	/**
	 * @return array
	 */
	public function getMaps () {
		return $this->aMaps;
	}

	/**
	 * @return array
	 */
	public function getControllerMaps () {
		return $this->aControllerMaps;
	}

	/**
	 * verifies if $sPath is on the path
	 * verifies if $sPath is a valid folder and it has a config/map.php file
	 * @param string $sPath
	 * @return bool
	 */
	public function isValidMap ($sPath) {
		return ((is_file ($sPath) && basename ($sPath) == 'map.php'));
	}

	public function isValidObject ($sPath) {
		return (is_file ($sPath) && substr ($sPath, -10) == '.class.php');
	}

	public function getClassName ($sPath) {
		$sClassName	= substr(basename($sPath), 0, -10); // strlen('.class.php')
		$iKey		= array_search($sClassName, array_map('strtolower', get_declared_classes()));
		$aClasses	= get_declared_classes();
		return  $aClasses[$iKey];
	}

	public function addModuleMap ($oMap) {
		$GLOBALS['__map'] = $oMap;
	}

	/**
	 * @return vscMapping
	 */
	public function getModuleMap () {
		if (key_exists ('__map', $GLOBALS) && $GLOBALS['__map'] instanceof vscMapping) {
			return $GLOBALS['__map'];
		} else {
			return new vscNull();
		}
	}

	public function mapController ($sRegex, $sPath) {
		if (!$sRegex) {
			throw new vscExceptionSitemap ('An URI must be present.');
		}
		if ($this->isValidObject ($sPath)) {
			$oNewMap 	= new vscMapping($sPath, $sRegex);

			$this->aControllerMaps[$sRegex] = $oNewMap;
			$this->setBasePath($sRegex);

			return $oNewMap;
		}
	}

	/**
	 *
	 * @param string $sRegex
	 * @param string $sPath
	 * @return vscMapping
	 */
	public function map ($sRegex, $sPath) {
		if (!$sRegex) {
			throw new vscExceptionSitemap ('An URI must be present.');
		}
		if (empty($sPath) && is_file($sPath)) {
			throw new vscExceptionSitemap ('The path associated with ['.$sRegex.'] can\'t be empty or an invalid file.');
		}

		// Valid site map
		if ($this->isValidMap ($sPath)) {
			$sMap = $this->getBasePath();
			$aResources = $this->getModuleMap()->getResources();

			$this->setBasePath ($sMap . $sRegex);
			$oModuleMap = new vscMapping($sPath, $sRegex);
			$this->addModuleMap($oModuleMap);
			include ($sPath);

			$this->getModuleMap()->setResources($aResources);
			$this->setBasePath ($sMap);
			return $this->getModuleMap();
		}

		// Valid processor
		if ($this->isValidObject ($sPath)) {
			return $this->addMap ($sRegex, $sPath);
		}

		throw new vscExceptionSitemap('The object ['.$sPath.'] could not be loaded.');
	}
}
