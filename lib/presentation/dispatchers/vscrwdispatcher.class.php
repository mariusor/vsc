<?php
/**
 * Parses the current request into a valid Front Controller / Controller pair
 * @package vsc_presentation
 * @subpackage dispatchers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.09.24
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
		$aMaps		= $this->getSiteMap ()->getMaps();
		$aRegexes	= array_keys($aMaps);
		$aMatches 	= array();

		$sUri = $this->getRequest()->getRequestUri();
		foreach ($aRegexes as $sRegex) {
			$iMatch			= preg_match ('|' . $sRegex.'[/]*|i',  $sUri, $aMatches);
			if ($iMatch) break;
		}

		$sPath = $aMaps[$sRegex];
		if ($this->getSiteMap()->isValidProcessor ($sPath)) {
			include ($sPath);

			$sProcessorName = $this->getSiteMap()->getProcessorName($sPath);
			array_shift($aMatches); // removing the matching string

			return new $sProcessorName($aMatches);
		} elseif ($this->getSiteMap()->isValidMap ($sPath)) {
			$this->getSiteMap()->map ($sRegex, $sPath);
			return $this->getProcessController();
		}

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
//		$this->getSiteMap()->setBasePath ($sIncPath);
		try {
			// hic sunt leones
			$this->getSiteMap()->map ('^/', $sIncPath);
		} catch (vscExceptionSitemap $e) {
			// there was a faulty controller in the sitemap
			// d ($e);
		}
	}
}
