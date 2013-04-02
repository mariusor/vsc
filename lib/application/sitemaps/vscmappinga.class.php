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
	private $sTemplate;
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

	private $aControllerMaps = array();

	private $aTaintedVars;

	/**
	 * @var vscMappingA
	 */
	private $oParentMap;

	private $sMatchingUrl;

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
		if (!is_null($sParentPath) && is_null($this->getTemplatePath())) {
			$this->setTemplatePath($sParentPath);
		}

		$sParentTemplate = $oMap->getTemplate();
		if (!is_null($sParentTemplate)  && is_null($this->getTemplate())) {
			$this->setTemplate($sParentTemplate);
		}

		if (($this instanceof vscContentTypeMappingI) && ($oMap instanceof vscContentTypeMappingI)) {
			$sParentMainTemplatePath = $oMap->getMainTemplatePath();
			if (!is_null($sParentMainTemplatePath) && is_null($this->getMainTemplatePath())) {
				$this->setMainTemplatePath($sParentMainTemplatePath);
			}
			$sParentMainTemplate = $oMap->getMainTemplate();
			if (!is_null($sParentMainTemplate)  && is_null($this->getMainTemplate())) {
				$this->setMainTemplate($sParentMainTemplate);
			}
		}
	}

	public function merge ($oMap = null) {
		if (vscMappingA::isValid($oMap)) {
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
		if (!is_dir($sPath)) {
			$sPath = $this->getModulePath() . $sPath;
		}
		if (!is_dir($sPath)) {
			throw new vscExceptionSitemap('Template path is not valid.');
		}

		$this->sViewPath = $sPath;
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
		if (vscMappingA::isValid($this->oParentMap)) {
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
		if ($oUrl->isLocal()) // I had a bad habit of correcting external URL's
		$sPath = $oUrl->getCompleteUri(true);
		$this->aResources['styles'][$sMedia][] = $sPath;
	}

	/**
	 *
	 * Adds a path for a JavaScript resource
	 * @param string $sPath
	 * @param bool $bInHead
	 */
	public function addScript ($sPath, $bInHead = false) {
		$oUrl = new vscUrlRWParser($sPath);
		$iMainKey = (int)$bInHead; // [1] in the <head> section; [0] at the end of the *HTML document
		if ($oUrl->isLocal()) {// I had a bad habit of correcting external URL's
			$sPath = $oUrl->getCompleteUri();
		}
		$this->aResources['scripts'][$iMainKey][] 		= $sPath;
	}

	/**
	 * @param string $sType The type of the link element (eg, application/rss+xml or image/png)
	 * @param string $aData The rest of the link's attributes (href, rel, s/a)
	 * @return void
	 */
	public function addLink ($sType, $aData) {
		if (key_exists('href', $aData)) {
			$oUrl = new vscUrlRWParser($aData['href']);
			if ($oUrl->isLocal()) { // I had a bad habit of correcting external URL's
				$sPath = $oUrl->getCompleteUri(true);
			} else {
				$sPath = $aData['href'];
			}
			$aData['href'] = $sPath;
		}
		if (key_exists('src', $aData)) {
			$oUrl = new vscUrlRWParser($aData['src']);
			if ($oUrl->isLocal()) { // I had a bad habit of correcting external URL's
				$sPath = $oUrl->getCompleteUri(true);
			} else {
				$sPath = $aData['src'];
			}
			$aData['src'] = $sPath;
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

	/**
	 *
	 * @param string $sRegex
	 * @param string $sPath
	 * @throws vscExceptionSitemap
	 * @return vscControllerMap
	 */
	public function mapController ($sRegex, $sPath){
		if (!$sRegex) {
			throw new vscExceptionSitemap ('An URI must be present.');
		}
		$sPath = str_replace(array('/','\\'), array(DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR),$sPath);

		if (!vscSiteMapA::isValidObject ($sPath)) {
			$sPath = $this->getModulePath() . $sPath;
		}
		if (vscSiteMapA::isValidObject ($sPath)) {
			$sKey = $sRegex;
			if (!is_array($this->aControllerMaps) || !key_exists($sKey, $this->aControllerMaps)) {
				$oNewMap 	= new vscControllerMap($sPath, $sKey);
				$oNewMap->setModuleMap($this);
				$oNewMap->merge($this);

				$this->aControllerMaps[$sKey] = $oNewMap;

				return $oNewMap;
			}
		} else {
			throw new vscExceptionController('Controller ['.$sPath.'] is invalid.');
		}
		return new vscNull();
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

	public function getScripts ($bInHead = false) {
		$aAllScripts = $this->getResources('scripts');
		if ($bInHead && key_exists(1, $aAllScripts)) {
			return $aAllScripts[1];
		}

		if (!$bInHead && key_exists(0, $aAllScripts))  {
			return $aAllScripts[0]; // [1] -> script goes in the <head> [0] - script is loaded at the end of the source
		}
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

	public function setUrl ($sUrl) {
		$this->sMatchingUrl = $sUrl;
	}

	/**
	 * @return vscUrlParserA
	 */
	public function getUrl () {
		$sRegex = '#(' . str_replace('#', '\#', $this->getRegex()). ')#iU';
		$bHaveMatch = preg_match ($sRegex, $this->sMatchingUrl, $aMatches);

		if ($bHaveMatch) {
			return new vscUrlRWParser($aMatches[0]);
		} else {
			return new vscNull();
		}
	}
}