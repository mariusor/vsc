<?php
/**
 * @package vsc_application
 * @subpackage sitemaps
 * @author marius orcisk <marius@habarnam.ro>
 * @date 09.11.29
 */
//import ('infrastructure/urls');

class vscMappingA extends vscObject {
	private $sRegex;
	private $sPath;

	/**
	 * the local template path - will be used to compose something like
	 * this->sViewPath . view->typeOfView . this->sTemplate
	 *
	 * @var string
	 */
	private $sViewPath;

	private $sTitle;
	private $aResources = array();
	private $bIsStatic = false;

	private $sTemplate;

	private $aControllerMaps = array();

	private $aTaintedVars;

	/**
	 * @var vscMappingA
	 */
	private $oParentMap;

	public function __construct ($sPath, $sRegex) {
		$this->sPath	= $sPath;
		$this->sRegex	= $sRegex;
	}

	public function getRegex () {
		return $this->sRegex;
	}

	public function setIsStatic($bStatic){
		$this->bIsStatic = $bStatic;
	}
	public function isStatic() {
		return $this->bIsStatic;
	}

	public function setResources ($aResources) {
		$this->aResources = $aResources;
	}

	protected function mergeResources ($oMap) {
		$aLocalResources	= $this->getResources();
		$aParentResources	= $oMap->getResources();
		$aResources = array_merge($aLocalResources, $aParentResources);
		// maybe I should merge the regexes too like processor_regex . '.*' . controller_regex

		$this->aResources = $aResources;
	}

	/**
	 * @param vscControllerMap $oMap
	 */
	protected function mergePaths ($oMap) {
		$sParentPath = $oMap->getTemplatePath();
		if ($sParentPath) {
			$this->setTemplatePath($sParentPath);
		}

		if ($this instanceof vscContentTypeMappingI) {
			$sParentMainPath = $oMap->getMainTemplatePath();
			if (!empty($sParentMainPath)) {
				$this->setMainTemplatePath($sParentMainPath);
			}
			$sParentTemplate = $oMap->getMainTemplate();
			if (!empty($sParentTemplate)) {
				$this->setMainTemplate($sParentTemplate);
			}
		}
	}

	public function merge ($oMap = null) {
		if ($oMap instanceof vscMappingA) {
			$this->mergeResources ($oMap);
			$this->mergePaths ($oMap);
		}
		return $this;
	}

	public function setTitle ($sTitle) {
		$this->sTitle = $sTitle;
	}

	public function getTitle () {
		return $this->sTitle;
	}

	public function setTemplatePath ($sPath) {
		(string)$this->sViewPath .= $sPath;
	}

	public function getTemplatePath () {
		return $this->sViewPath;
	}

	public function setTemplate ($sPath) {
		$this->sTemplate = $sPath;
	}

	public function getTemplate () {
		return $this->sTemplate;
	}

	public function setModuleMap (vscMappingA $oMap) {
		$this->oParentMap = $oMap;
	}

	/**
	 * @return vscModuleMap
	 */
	public function getModuleMap () {
		if ($this->oParentMap instanceof vscMappingA) {
			return $this->oParentMap;
		} else {
			return new vscNull();
		}
	}

	public function getModulePath () {
		$sModulePath = $this->getPath();
		if (!vscSiteMapA::isValidMap($sModulePath) && vscSiteMapA::isValidObject($sModulePath)) {
			$sModulePath = $this->getModuleMap()->getPath();
		}

		$sModulePath = realpath(dirname($sModulePath));
		if (basename ($sModulePath) == 'config') {
			$sModulePath = substr ($sModulePath, 0, -7);
		}
		return $sModulePath . DIRECTORY_SEPARATOR;

	}

	public function getModuleName() {
		return $this->getModulePath() ? basename ($this->getModulePath()) : null;
	}

	public function getPath () {
		return $this->sPath;
	}

	/**
	 * @param $sVar
	 * @param $sVal
	 * @return void
	 */
	public function addSetting ($sVar, $sVal) {
		$this->aResources['settings'][$sVar] = $sVal;
	}

	public function addStyle ($sPath, $sMedia = 'screen') {
		$oUrl = new vscUrlRWParser($sPath);
		$this->aResources['styles'][$sMedia][] = $oUrl->getCompleteUri(true);
	}

	public function addScript ($sPath) {
		$oUrl = new vscUrlRWParser($sPath);
		$this->aResources['scripts'][] = $oUrl->getCompleteUri(true);
	}

	/**
	 * @param string $sType The type of the link element (eg, application/rss+xml or image/png)
	 * @param string $aData The rest of the link's attributes (href, rel, s/a)
	 * @return void
	 */
	public function addLink ($sType, $aData) {
		if (key_exists('href', $aData)) {
			$oUrl = new vscUrlRWParser($aData['href']);
			$aData['href'] = $oUrl->getCompleteUri(true);
		}
		if (key_exists('src', $aData)) {
			$oUrl = new vscUrlRWParser($aData['src']);
			$aData['src'] = $oUrl->getCompleteUri(true);
		}
		$this->aResources['links'][$sType][] = $aData;
	}

	public function addMeta ($sName, $sValue) {
		$this->aResources['meta'][$sName] = $sValue;
	}

	public function getResources ($sType = null) {
		if (!is_null($sType)) {
			if (key_exists($sType, $this->aResources)) {
				$aResources = $this->aResources[$sType];
			} else {
				$aResources = array();
			}

			return $aResources;
		} else {
			return $this->aResources;
		}
	}

	public function mapController ($sRegex, $sPath){
		if (!$sRegex) {
			throw new vscExceptionSitemap ('An URI must be present.');
		}
		if (vscSiteMapA::isValidObject ($sPath)) {
			$sKey = $sRegex;
			if (!is_array($this->aControllerMaps) || !key_exists($sKey, $this->aControllerMaps)) {
				$oNewMap 	= new vscControllerMap($sPath, $sKey);
				$oNewMap->setModuleMap($this);
//				$oNewMap->merge($this); //? ?
//				d ($this);

				$this->aControllerMaps[$sKey] = $oNewMap;

				return $oNewMap;
			}
		}
	}

	/**
	 * @return array
	 */
	public function getControllerMaps () {
		return $this->aControllerMaps;
	}

	public function getStyles ($sMedia = null) {
		$aStyles					= $this->getResources('styles');
		if (!is_null($sMedia)) {
			$aMediaStyles[$sMedia]	= $aStyles[$sMedia];
			return key_exists ($sMedia, $aStyles) ? $aMediaStyles : null;
		} else {
			return $aStyles;
		}
	}

	public function getMetas ($sName = null) {
		$aMetas =  $this->getResources('meta');
		if (!is_null($sName)) {
			return key_exists ($sName,$aMetas) ?  $aMetas[$sName] : '';
		} else {
			return $aMetas;
		}
	}

	public function getScripts () {
		return $this->getResources('scripts');
	}

	public function getSettings () {
		return $this->getResources ('settings');
	}

	/**
	 * @param string $sType
	 * @return array
	 */
	public function getLinks ($sType = null) {
		$aLinks = $this->getResources ('links');

		if (!is_null($sType)) {
			if (key_exists($sType, $aLinks)) {
				$aTLinks[$sType] = $aLinks[$sType];
				$aLinks = $aTLinks;
			} else {
				$aLinks = array($sType => array()); // kinda hackish, but needed to have a uniform structure
			}
		}
		return $aLinks;
	}

	/**
	 * @param string $sVar
	 * @return array
	 */
	public function getSetting ($sVar) {
		$aSettings = $this->getResources ('settings');

		if (key_exists($sVar, $aSettings)) {
			return $aSettings[$sVar];
		} else {
			return '';
		}
	}

	public function setTaintedVars ($aVars) {
		$this->aTaintedVars = $aVars;
	}

	public function getTaintedVars () {
		return $this->aTaintedVars;
	}
}