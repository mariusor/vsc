<?php
/**
 * Parses the current request into a valid Front Controller / Controller pair
 * @package vsc_presentation
 * @subpackage dispatchers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.07.10
 */
class vscRwDispatcher {
	/**
	 * @var vscHttpRequestA
	 */
	private $oRequest;
	/**
	 * @var vscRwSiteMap
	 */
	private $oSiteMap;

	public function __construct (){
	}

	/**
	 *
	 * @return vscFrontController
	 */
	public function getFrontController () {
		import ('presentation/controllers');
		return new vscHtmlFrontController ();
	}

	public function getProcessController () {
		$aMaps = $this->oSiteMap->getAllMaps();
		$aVars = array ();

		if (is_array($aMaps)) {
			$sUri = $this->getRequest()->getRequestUri();
//			var_dump($sUri);
			/* @var $oControllerMap vscMappingController */
			foreach ($aMaps as $oControllerMap) {
//				$controllerMatch	= preg_match ('/'.$oControllerMap->getName().'/i', $this->getRequest()->getRequestUri());
				$iMatch			= preg_match ('|' . $oControllerMap->getUrl().'[/]*|i',  $sUri, $aMatches);
				$aTaintedVars	= $this->getRequest()->getTaintedVars ();
				if (($iMatch)) {
					array_shift($aMatches);

					foreach ($aTaintedVars as $sVarName => $sVarVal) {
						if (in_array($sVarVal, $aMatches)) {
							$aVars[$sVarName] = $sVarVal;
						}
					}

					$oSpecificController = $oControllerMap->getInstance ($aVars);

					return $oSpecificController;
				}
//				var_dump ('|' . $oControllerMap->getUrl().'|i', $aMatches );
			}
		}
//		die();

		return null;
	}

	/**
	 *
	 * @param string $sIncPath
	 * @throws vscExceptionPath
	 * @return void
	 */
	public function loadSiteMap ($sIncPath) {
		import ('presentation/sitemaps');
		$this->oSiteMap = new vscRwSiteMap ();
		$this->oSiteMap->setBasePath ($sIncPath);
		try {
			$this->oSiteMap->mapModule ('^/', '.');
		} catch (vscExceptionSitemap $e) {
			// there was a faulty controller in the sitemap
		}
	}

	public function getRequest () {
		$this->oRequest = vsc::getHttpRequest();
		return $this->oRequest;
	}
}
