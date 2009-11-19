<?php
/**
 * @package vsc_application
 * @subpackage sitemaps
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.09.24
 */
abstract class vscSiteMapA {
	private $aBasePath;
	private $aMaps;
	private $aControllerMaps;

	public function __construct () {
	}

	public function setBasePath ($sPath) {
		$this->aBasePath = $sPath;
	}

	public function getBasePath () {
		return $this->aBasePath;
	}

	public function addMap ($sRegex, $sPath) {
		$sKey = $this->getBasePath() . $sRegex;
		if (!is_array($this->aMaps) || !key_exists($sKey, $this->aMaps))
			$this->aMaps[$sKey] 	= $sPath;
	}

	public function getMaps () {
		return $this->aMaps;
	}

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

	public function getObjectName ($sPath) {
		$sClassName	= substr(basename($sPath), 0, -10); // strlen('.class.php')
		$iKey		= array_search($sClassName, array_map('strtolower', get_declared_classes()));
		$aClasses	= get_declared_classes();
		return  $aClasses[$iKey];
	}

	public function mapController ($sRegex, $sPath) {
		if (!$sRegex) {
			throw new vscExceptionSitemap ('An URI must be present.');
		}
		if ($this->isValidObject ($sPath)) {
			$this->aControllerMaps[$sRegex] = $sPath;
		}
	}

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

			$this->setBasePath ($sMap . $sRegex);
			include ($sPath);

			$this->setBasePath ($sMap);
			return;
		}

		// Valid processor
		if ($this->isValidObject ($sPath)) {
			$this->addMap ($sRegex, $sPath);
			return;
		}

		return;
//		throw new vscExceptionSitemap ('The path [' . ($sPath). '] could not be resolved to either a site map or a processor.');
	}
}
