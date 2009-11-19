<?php
/**
 * Parses the current request into a valid Front Controller / Controller pair
 * @package vsc_presentation
 * @subpackage dispatchers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.09.24
 */
import ('application/controllers');
import ('application/processors');
import ('coreexceptions');
class vscRwDispatcher extends vscDispatcherA {

	/**
	 * @return vscFrontControllerA
	 */
	public function getFrontController () {
		$aMaps		= $this->getSiteMap ()->getControllerMaps();
		if (!is_array($aMaps)) {
			return new vscHtmlController ();
		}
		$aRegexes	= array_keys($aMaps);
		$aMatches 	= array();

		$sUri = $this->getRequest()->getRequestUri();
		foreach ($aRegexes as $sRegex) {
			$iMatch			= preg_match ('|' . $sRegex.'|Ui',  $sUri, $aMatches);
			if ($iMatch) break;
		}

		$sPath = $aMaps[$sRegex];
		if ($this->getSiteMap()->isValidObject ($sPath)) {
			include ($sPath);

			$sControllerName = $this->getSiteMap()->getObjectName($sPath);
			return new $sControllerName();
		}
		return new vscHtmlController ();
	}

	/**
	 * (non-PHPdoc)
	 * @see lib/presentation/dispatchers/vscDispatcherA#getProcessController()
	 * @return vscProcessorA
	 */
	public function getProcessController () {
		$aMaps		= $this->getSiteMap ()->getMaps();

		if (!is_array($aMaps)) {
			return new vsc404Processor();
		}

		$aRegexes	= array_keys($aMaps);
		$aMatches 	= array();

		$sUri = $this->getRequest()->getRequestUri();
		foreach ($aRegexes as $sRegex) {
			$iMatch			= preg_match ('|' . $sRegex.'[/]*|Ui',  $sUri, $aMatches);
			if ($iMatch) break;
		}

		$sPath = $aMaps[$sRegex];

		if ($this->getSiteMap()->isValidObject ($sPath)) {
			include ($sPath);

			$sProcessorName = $this->getSiteMap()->getObjectName($sPath);
			array_shift($aMatches); // removing the matching string

			/* @var $oProcessor vscProcessorA */
			$oProcessor = new $sProcessorName($aMatches);

			// setting the variables defined in the processor into the tainted variables
			$this->getRequest()->setTaintedVars ($oProcessor->getLocalVars());

			return $oProcessor;
		}

 		return new vsc404Processor();
	}

	/**
	 *
	 * @param string $sIncPath
	 * @throws vscExceptionPath
	 * @return void
	 */
	public function loadSiteMap ($sIncPath) {
		$this->setSiteMap (new vscRwSiteMap ());
		try {
			// hic sunt leones
			$this->getSiteMap()->map ('^/', $sIncPath);
		} catch (vscExceptionSitemap $e) {
			// there was a faulty controller in the sitemap
			 d ($e);
		}
	}
}
