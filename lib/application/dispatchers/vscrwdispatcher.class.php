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
		if (!is_array($aMaps))
			return '';

		$aRegexes	= array_keys($aMaps);
		$aMatches 	= array();

		try {
			mb_internal_encoding('utf-8');
			$sUri = $this->getRequest()->getRequestUri(true); // get it as a urldecoded string
			foreach ($aRegexes as $sRegex) {
				$iMatch			= mb_eregi (str_replace('/', '\/', $sRegex),  $sUri, $aMatches);
				if ($iMatch) {
					break;
				}
			}
		} catch (Exception $e) {
			d ($e);
		}
		return $aMaps[$sRegex];
	}

	/**
	 * @return vscFrontControllerA
	 */
	public function getFrontController () {
		$aMaps				= $this->getSiteMap()->getControllerMaps();
		$oControllerMapping	= $this->getCurrentMap($aMaps);
		if ($oControllerMapping instanceof vscMapping) {
			$sPath 				= $oControllerMapping->getPath();
		} else {
			$sPath = '';
		}

		if ($this->getSiteMap()->isValidObject ($sPath)) {
			include ($sPath);

			$sControllerName = $this->getSiteMap()->getClassName($sPath);

			/* @var $oFront vscFrontControllerA */
			$oFront = new $sControllerName();
			// adding the map to the controller, allows it to add resources (styles,scripts) from inside it
			$oFront->setMap ($oControllerMapping);

			return $oFront;
		}

		return new vscXhtmlController ();
	}

	/**
	 * (non-PHPdoc)
	 * @see lib/presentation/dispatchers/vscDispatcherA#getProcessController()
	 * @return vscProcessorA
	 */
	public function getProcessController () {
		$aMaps				= $this->getSiteMap()->getMaps();
		$oProcessorMapping	= $this->getCurrentMap($aMaps);
		if ($oProcessorMapping instanceof vscMapping) {
			$sPath 				= $oProcessorMapping->getPath();
		} else {
			$sPath = '';
		}

		if ($this->getSiteMap()->isValidObject ($sPath)) {
			include ($sPath);

			$sProcessorName = $this->getSiteMap()->getClassName($sPath);

			/* @var $oProcessor vscProcessorA */
			$oProcessor = new $sProcessorName();

		} else {
			$oProcessor = new vsc404Processor();
		}

		// adding the map to the processor, allows it to easy add resources (styles,scripts) from inside it
		$oProcessor->setMap ($oProcessorMapping);

		// setting the variables defined in the processor into the tainted variables
		$this->getRequest()->setTaintedVars ($oProcessor->getLocalVars()); // FIXME!!!
		return $oProcessor;

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
