<?php
class vscMapping {
	private $sRegex;
	private $sPath;

	private $sViewPath;

	private $sTitle;
	private $aResources = array();

	private $sMainTemplate;

	public function __construct ($sPath, $sRegex) {
		$this->sPath	= $sPath;
		$this->sRegex			= $sRegex;
	}

	public function merge ($oMap = null) {
		if ($oMap instanceof vscMapping) {
			$aLocalResources	= $this->getResources();
			$aRemoteResources	= $oMap->getResources();
			$aResources = array_merge($aLocalResources, $aRemoteResources);
			// maybe I should merge the regexes too like processor_regex . '.*' . controller_regex

			$this->aResources = $aResources;
		}
		return $this;
	}

	public function setTitle ($sTitle) {
		$this->sTitle = $sTitle;
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

	public function addSetting ($sVar, $sVal) {
		$this->aResources['settings'][$sVar] = $sVal;
	}

	public function addStyle ($sPath, $sMedia = 'screen') {
		$this->aResources['styles'][$sMedia][] = $sPath;
	}

	public function addScript ($sPath) {
		$this->aResources['scripts'][] = $sPath;
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
		$aStyles				= $this->getResources('styles');
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

	public function getSetting ($sVar) {
		$aSettings = $this->getResources ('settings');

		if (key_exists($sVar, $aSettings)) {
			return $aSettings[$sVar];
		} else {
			return '';
		}
	}
}