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
	 * @param array $aMaps
	 * @return vscMapping
	 */
	public function getCurrentMap ($aMaps) {
		$aRegexes	= array_keys($aMaps);
		$aMatches 	= array();

		$sUri = $this->getRequest()->getRequestUri();
		foreach ($aRegexes as $sRegex) {
			$iMatch			= preg_match ('|' . $sRegex.'|Ui',  $sUri, $aMatches);
			if ($iMatch) break;
		}

		return $aMaps[$sRegex];
	}

	/**
	 * @return vscFrontControllerA
	 */
	public function getFrontController () {
		$aMaps				= $this->getSiteMap ()->getControllerMaps();
		$oControllerMapping	= $this->getCurrentMap($aMaps);

		$sPath 				= $oControllerMapping->getPath();

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
		$aMaps				= $this->getSiteMap ()->getMaps();
		$oProcessorMapping	= $this->getCurrentMap($aMaps);
		$sPath 				= $oProcessorMapping->getPath();

		if ($this->getSiteMap()->isValidObject ($sPath)) {
			include ($sPath);

			$sProcessorName = $this->getSiteMap()->getObjectName($sPath);

			/* @var $oProcessor vscProcessorA */
			$oProcessor = new $sProcessorName();

			// setting the variables defined in the processor into the tainted variables
//			$this->getRequest()->setTaintedVars ($oProcessor->getLocalVars());

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
//			 d ($e);
		}
	}

	public function getView () { }

	public function getTemplatePath () {
		$aMaps				= $this->getSiteMap ()->getMaps();
		$oProcessorMapping = $this->getCurrentMap($aMaps);

		return $oProcessorMapping->getTemplate();
	}
}
