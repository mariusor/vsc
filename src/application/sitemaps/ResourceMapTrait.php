<?php
/**
 * @package application
 * @subpackage sitemaps
 * @author marius orcisk <marius@habarnam.ro>
 * @date 17.01.25
 */
namespace vsc\application\sitemaps;

use vsc\infrastructure\urls\UrlParserA;

trait ResourceMapTrait
{
	/**
	 * @var string
	 */
	private $sTitle;

	/**
	 * @var array
	 */
	private $aResources = [];

	/**
	 * @return string
	 * @throws ExceptionSitemap
	 */
	abstract public function getModulePath();

	/**
	 * @param string $sTitle
	 */
	public function setTitle($sTitle) {
		$this->sTitle = $sTitle;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->sTitle;
	}


	/**
	 * @param array $aResources
	 */
	public function setResources($aResources) {
		$this->aResources = $aResources;
	}

	/**
	 * @param ResourceMapTrait $oMap
	 */
	protected function mergeResources($oMap) {
		$aResources = $this->getResources();
		if ($oMap instanceof ResourceMapInterface) {
			$aParentResources = $oMap->getResources();
			// iterate over our resources and merging with matching existing parent resources
			foreach ($aResources as $resType => $resources) {
				if (!isset($aParentResources[$resType])) { continue; }

				foreach ($resources as $key => $path) {
					if (!isset($aParentResources[$resType][$key])) {  continue; }
					$aResources[$resType][$key] = array_merge($aResources[$resType][$key], $aParentResources[$resType][$key]);
					unset ($aParentResources[$resType][$key]);
				}
			}
			// adding elements that exist just in parent resources
			foreach ($aParentResources as $resType => $resources) {
				if (!isset($aParentResources[$resType])) { $aResources[$resType] = []; }

				foreach ($resources as $key => $path) {
					$aResources[$resType][$key] = $aParentResources[$resType][$key];
				}
			}
		}
		$this->aResources = $aResources;
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

	/**
	 * @param string $sPath
	 * @return string
	 */
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

	/**
	 * @param string $sPath
	 * @param string $sMedia
	 */
	public function addStyle($sPath, $sMedia = 'screen') {
		$this->aResources['styles'][$sMedia][] = $this->getResourcePath($sPath);
	}

	/**
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

	/**
	 * @param string $sName
	 * @param string $sValue
	 * @return void
	 */
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
	 * @param null $sMedia
	 * @return array|null
	 */
	public function getStyles($sMedia = null) {
		$aStyles = $this->getResources('styles');
		if (!is_null($sMedia)) {
			$aMediaStyles[$sMedia] = $aStyles[$sMedia];
			return array_key_exists($sMedia, $aStyles) ? $aMediaStyles : null;
		} else {
			return $aStyles;
		}
	}

	/**
	 * @param null $sName
	 * @return array|string
	 */
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

	/**
	 * @return array
	 */
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

	/**
	 * @return array
	 */
	public function getHeaders() {
		return $this->getResources('headers');
	}

}
