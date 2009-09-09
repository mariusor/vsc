<?php
/**
 * Parses the current request into a valid Front Controller / Controller pair
 * @package vsc_presentation
 * @subpackage dispatchers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.07.10
 */
import ('presentation/controllers');
import ('presentation/processors');
class vscRwDispatcher extends vscDispatcherA {

	/**
	 * @return vscFrontControllerA
	 */
	public function getFrontController () {
		return new vscHtmlFrontController ();
	}

	/**
	 * (non-PHPdoc)
	 * @see lib/presentation/dispatchers/vscDispatcherA#getProcessController()
	 * @return vscProcessorA
	 */
	public function getProcessController () {
		$aVars = array ();
		try {
			$aMaps = $this->getSiteMap()->getAllMaps();
		} catch (vscException $e) {
			// we don't have a sitemap
			return null;
		}
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
		$this->setSiteMap (new vscRwSiteMap ());
		$this->getSiteMap()->setBasePath ($sIncPath);
		try {
			$this->getSiteMap()->mapModule ('^/', '.');
		} catch (vscExceptionSitemap $e) {
			// there was a faulty controller in the sitemap
		}
	}
}
