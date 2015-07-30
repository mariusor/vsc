<?php
/**
 * @package application
 * @subpackage sitemaps
 * @author marius orcisk <marius@habarnam.ro>
 * @date 09.11.29
 */
namespace vsc\application\sitemaps;

use vsc\application\controllers\ExceptionController;
use vsc\infrastructure\urls\Url;
use vsc\infrastructure\urls\UrlParserA;
use vsc\infrastructure\Base;
use vsc\infrastructure\Object;
use vsc\presentation\requests\HttpAuthenticationA;

abstract class MappingA extends Object {
	/**
	 * @var  string
	 */
	private $sRegex;
	/**
	 * @var string
	 */
	private $sPath;
	/**
	 * @var string
	 */
	private $sTemplate;
	/**
	 * the local template path - will be used to compose something like
	 * this->sViewPath . view->typeOfView . this->sTemplate
	 *
	 * @var string
	 */
	private $sViewPath;

	private $sTitle;
	private $aResources = [];
	private $bIsStatic = false;

	private $aControllerMaps = array();

	private $aTaintedVars = [];

	/**
	 * @var MappingA
	 */
	private $oParentMap;

	private $sMatchingUrl;

	/**
	 * @var int
	 */
	private $iAuthenticationType = null;

	/**
	 * @param string $sPath
	 * @param string $sRegex
	 */
	public function __construct($sPath, $sRegex) {
		$this->sPath = $sPath;
		$this->sRegex = $sRegex;
	}

	public function getRegex() {
		return $this->sRegex;
	}

	/**
	 * @param bool $bStatic
	 */
	public function setIsStatic($bStatic) {
		$this->bIsStatic = $bStatic;
	}

	/**
	 * @return bool
	 */
	public function isStatic() {
		return $this->bIsStatic;
	}

	/**
	 * @param array $aResources
	 */
	public function setResources($aResources) {
		$this->aResources = $aResources;
	}

	/**
	 * @param MappingA $oMap
	 */
	protected function mergeResources($oMap) {
		$aLocalResources = $this->getResources();
		$aParentResources = $oMap->getResources();
		$aResources = array_merge($aLocalResources, $aParentResources);
		// maybe I should merge the regexes too like processor_regex . '.*' . controller_regex

		$this->aResources = $aResources;
	}

	/**
	 * @param MappingA $oMap
	 */
	protected function mergePaths($oMap) {
		$sParentPath = $oMap->getTemplatePath();
		if (!is_null($sParentPath) && is_null($this->getTemplatePath())) {
			$this->setTemplatePath($sParentPath);
		}

		$sParentTemplate = $oMap->getTemplate();
		if (!is_null($sParentTemplate) && is_null($this->getTemplate())) {
			$this->setTemplate($sParentTemplate);
		}

		if (($this instanceof ContentTypeMappingI) && ($oMap instanceof ContentTypeMappingI)) {
			/** @var ContentTypeMappingI $oMap */
			$sParentMainTemplatePath = $oMap->getMainTemplatePath();
			if (is_null($this->getMainTemplatePath())) {
				$this->setMainTemplatePath($sParentMainTemplatePath);
			}
			$sParentMainTemplate = $oMap->getMainTemplate();
			if (is_null($this->getMainTemplate())) {
				$this->setMainTemplate($sParentMainTemplate);
			}
		}
	}

	/**
	 * @param MappingA $oMap
	 * @return $this
	 */
	public function merge($oMap = null) {
		if (MappingA::isValid($oMap)) {
			$this->mergeResources($oMap);
			$this->mergePaths($oMap);

			$sTitle = $this->getTitle();
			$sMapTitle = $oMap->getTitle();
			if (empty($sTitle) && !empty($sMapTitle)) {
				$this->setTitle($sMapTitle);
			}
			$this->iAuthenticationType |= $oMap->getAuthenticationType();
		}
		return $this;
	}

	public function setTitle($sTitle) {
		$this->sTitle = $sTitle;
	}

	public function getTitle() {
		return $this->sTitle;
	}

	/**
	 * @param string $sPath
	 * @return bool
	 * @throws ExceptionSitemap
	 */
	public function setTemplatePath($sPath) {
		$this->sViewPath = $this->getValidPath($sPath);
	}

	/**
	 * @return string
	 */
	public function getTemplatePath() {
		return $this->sViewPath;
	}

	/**
	 * @param string $sPath
	 */
	public function setTemplate($sPath) {
		$this->sTemplate = $sPath;
	}

	/**
	 * @return string
	 */
	public function getTemplate() {
		return $this->sTemplate;
	}

	public function setModuleMap(MappingA $oMap) {
		$this->oParentMap = $oMap;

		foreach ($oMap->getControllerMaps() as $sRegex => $oControllerMap) {
			if (!array_key_exists($sRegex, $this->aControllerMaps) && ClassMap::isValid($oControllerMap)) {
				$this->aControllerMaps[$sRegex] = $oControllerMap;
			}
		}
	}

	/**
	 * @returns ModuleMap
	 */
	public function getModuleMap() {
		if (!MappingA::isValid($this->oParentMap)) {
			$this->oParentMap = new RootMap(VSC_RES_PATH . 'config/map.php');
		}
		return $this->oParentMap;
	}

	/**
	 * @return string
	 * @throws ExceptionSitemap
	 */
	public function getModulePath() {
		$oModuleMap = $this->getModuleMap();
		return $oModuleMap->getModulePath();
	}

	/**
	 * @return string
	 */
	public function getModuleName() {
		return $this->getModulePath() ? basename($this->getModulePath()) : null;
	}

	/**
	 * @return string
	 */
	public function getPath() {
		return $this->sPath;
	}

	/**
	 * @param $sVar
	 * @return void
	 */
	public function removeHeader($sVar) {
		$this->aResources['headers'][$sVar] = null;
	}

	/**
	 * @param $sVar
	 * @param $sVal
	 * @return void
	 */
	public function addHeader($sVar, $sVal) {
		$this->aResources['headers'][$sVar] = $sVal;
	}

	/**
	 * @param $sVar
	 * @param $sVal
	 * @return void
	 */
	public function addSetting($sVar, $sVal) {
		$this->aResources['settings'][$sVar] = $sVal;
	}

	private function getResourcePath($sPath) {
		if (is_file($this->getModulePath() . $sPath)) {
			$sPath = $this->getModulePath() . $sPath;
		}
		$oUrl = UrlParserA::url($sPath);
		if ($oUrl->isLocal()) {
			// I had a bad habit of correcting external URL's
			$sPath = $oUrl->getPath();
		}
		return $sPath;
	}

	public function addStyle($sPath, $sMedia = 'screen') {
		$this->aResources['styles'][$sMedia][] = $this->getResourcePath($sPath);
	}

	/**
	 *
	 * Adds a path for a JavaScript resource
	 * @param string $sPath
	 * @param bool $bInHead
	 */
	public function addScript($sPath, $bInHead = false) {
		$iMainKey = (int)$bInHead; // [1] in the <head> section; [0] at the end of the *HTML document
		$this->aResources['scripts'][$iMainKey][] = $this->getResourcePath($sPath);
	}

	/**
	 * @param string $sType The type of the link element (eg, application/rss+xml or image/png)
	 * @param string $aData The rest of the link's attributes (href, rel, s/a)
	 * @return void
	 */
	public function addLink($sType, $aData) {
		if (array_key_exists('href', $aData)) {
			$aData['href'] = $this->getResourcePath($aData['href']);
		}
		if (array_key_exists('src', $aData)) {
			$aData['src'] = $this->getResourcePath($aData['src']); ;
		}
		$this->aResources['links'][$sType][] = $aData;
	}

	public function addMeta($sName, $sValue) {
		$this->aResources['meta'][$sName] = $sValue;
	}

	/**
	 * @param string $sType
	 * @return array
	 */
	public function getResources($sType = null) {
		if (!is_null($sType)) {
			if (array_key_exists($sType, $this->aResources)) {
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
	 * @throws ExceptionController
	 * @throws ExceptionSitemap
	 * @returns ClassMap
	 */
	public function map($sRegex, $sPath = null) {
		if (empty($sRegex)) {
			throw new ExceptionSitemap('An URI must be present.');
		}
		if (is_null($sPath)) {
			// if we only have one parameter, we treat it as a path
			$sPath = $sRegex;
			$sRegex = $this->getRegex();
		}

		$sKey = $sRegex;
		if (array_key_exists($sKey, $this->aControllerMaps)) {
			unset($this->aControllerMaps[$sKey]);
		}
		if (ClassMap::isValidMap($sPath)) {
			// instead of a path we have a namespace
			$oNewMap = new ClassMap($sPath, $sKey);
			$oNewMap->setModuleMap($this);
			$oNewMap->merge($this);

			$this->aControllerMaps[$sKey] = $oNewMap;

			return $oNewMap;
		} else {
			throw new ExceptionController('Controller [' . $sPath . '] is invalid.');
		}
	}

	/**
	 * @return MappingA[]
	 */
	public function getControllerMaps() {
		return $this->aControllerMaps;
	}

	public function getStyles($sMedia = null) {
		$aStyles = $this->getResources('styles');
		if (!is_null($sMedia)) {
			$aMediaStyles[$sMedia] = $aStyles[$sMedia];
			return array_key_exists($sMedia, $aStyles) ? $aMediaStyles : null;
		} else {
			return $aStyles;
		}
	}

	public function getMetas($sName = null) {
		$aMetas = $this->getResources('meta');
		if (!is_null($sName)) {
			return array_key_exists($sName, $aMetas) ? $aMetas[$sName] : '';
		} else {
			return $aMetas;
		}
	}

	/**
	 * @param bool $bInHead
	 * @return array
	 */
	public function getScripts($bInHead = false) {
		$aAllScripts = $this->getResources('scripts');
		if ($bInHead && array_key_exists(1, $aAllScripts)) {
			return $aAllScripts[1];
		}

		if (!$bInHead && array_key_exists(0, $aAllScripts)) {
			return $aAllScripts[0]; // [1] -> script goes in the <head> [0] - script is loaded at the end of the source
		}
		return [];
	}

	public function getSettings() {
		return $this->getResources('settings');
	}

	/**
	 * @param string $sType
	 * @return array
	 */
	public function getLinks($sType = null) {
		$aLinks = $this->getResources('links');

		if (!is_null($sType)) {
			if (array_key_exists($sType, $aLinks)) {
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
	 * @return array|string
	 */
	public function getSetting($sVar) {
		$aSettings = $this->getResources('settings');

		if (array_key_exists($sVar, $aSettings)) {
			return $aSettings[$sVar];
		} else {
			return '';
		}
	}

	public function getHeaders() {
		return $this->getResources('headers');
	}

	/**
	 * @param string[] $aVars
	 */
	public function setTaintedVars($aVars) {
		$this->aTaintedVars = $aVars;
	}

	public function getTaintedVars() {
		return $this->aTaintedVars;
	}

	/**
	 * @param string $sUrl
	 */
	public function setUrl($sUrl) {
		$this->sMatchingUrl = $sUrl;
	}

	/**
	 * @returns Url
	 */
	public function getUrl() {
		$sRegex = '#(' . str_replace('#', '\#', $this->getRegex()) . ')#iUu';
		$bHaveMatch = preg_match($sRegex, $this->sMatchingUrl, $aMatches);

		if ($bHaveMatch) {
			$url = new Url();
			$url->setPath($aMatches[0]);
			return $url;
		} else {
			return new Base();
		}
	}

	public function setAuthenticationType($iAuthenticationType) {
		$this->iAuthenticationType = $iAuthenticationType;
	}

	public function getAuthenticationType() {
		return $this->iAuthenticationType;
	}

	/**
	 * @return string
	 */
	public function getValidAuthenticationSchemas() {
		return HttpAuthenticationA::getAuthenticationSchemas($this->iAuthenticationType);
	}

	/**
	 * @return bool
	 */
	public function requiresAuthentication() {
		return ($this->iAuthenticationType != HttpAuthenticationA::NONE);
	}

	/**
	 * @param \vsc\infrastructure\Object $mappedObject
	 * @return boolean
	 */
	public function maps(Object $mappedObject)
	{
		return (bool)stristr(get_class($mappedObject), substr(basename($this->getPath()), 0, -4));
	}

	/**
	 * @param string $sPath
	 * @return string
	 * @throws ExceptionSitemap
	 */
	protected function getValidPath($sPath) {
		if (!is_dir($sPath)) {
			if (!ModuleMap::isValid($this) && !ModuleMap::isValid($this->getModuleMap())) {
				throw new ExceptionSitemap('No reference module path to use for relative paths');
			}
			$sPath = $this->getModulePath() . $sPath;
		}
		$sPath = realpath($sPath);
		if (!is_dir($sPath)) {
			throw new ExceptionSitemap('Template path is not valid.');
		}

		return $sPath . DIRECTORY_SEPARATOR;
	}
}

