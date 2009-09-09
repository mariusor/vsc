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
import ('coreexceptions');
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
			/* @var $oProcessorMap vscMappingProcessor */
			foreach ($aMaps as $oProcessorMap) {
//				$controllerMatch	= preg_match ('/'.$oProcessorMap->getName().'/i', $this->getRequest()->getRequestUri());
				$iMatch			= preg_match ('|' . $oProcessorMap->getUrl().'[/]*|i',  $sUri, $aMatches);
				$aTaintedVars	= $this->getRequest()->getTaintedVars ();
				if (($iMatch)) {
					array_shift($aMatches);

					foreach ($aTaintedVars as $sVarName => $sVarVal) {
						if (in_array($sVarVal, $aMatches)) {
							$aVars[$sVarName] = $sVarVal;
						}
					}

					include ($oProcessorMap->getPath());
					$oSpecificController = $oProcessorMap->getInstance ($aVars);

					return $oSpecificController;
				}
//				var_dump ('|' . $oProcessorMap->getUrl().'|i', $aMatches );
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
			d ($e);
		}
	}
}
