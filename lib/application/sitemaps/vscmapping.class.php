<?php
/**
 * @package vsc_application
 * @subpackage sitemaps
 * @author marius orcisk <marius@habarnam.ro>
 * @date 09.11.29
 */
import ('infrastructure/urls');

class vscMapping extends vscObject {
	private $sRegex;
	private $sPath;

	/**
	 * the local template path - will be used to compose something like
	 * this->sViewPath . view->typeOfView . this->sMainTemplate
	 *
	 * @var unknown_type
	 */
	private $sViewPath;

	private $sTitle;
	private $aResources = array();

	private $sMainTemplate;

	public function __construct ($sPath, $sRegex) {
		$this->sPath	= $sPath;
		$this->sRegex	= $sRegex;
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

	protected function mergePaths ($oMap) {
		$sParentPath = $oMap->getTemplatePath();
		if ($sParentPath) {
			$this->setTemplatePath($sParentPath);
		}
	}

	public function merge ($oMap = null) {
		if ($oMap instanceof vscMapping) {
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
		$this->sMainTemplate = $sPath;
	}

	public function getTemplate () {
		return $this->sMainTemplate;
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
}