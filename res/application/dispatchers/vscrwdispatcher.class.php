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
import ('presentation/responses');
import ('exceptions');

class vscRwDispatcher extends vscDispatcherA {
	/**
	 * @param array $aMaps
	 * @return vscMappingA
	 */
	public function getCurrentMap ($aMaps) {
		if (!is_array($aMaps) || empty($aMaps)) {
			return new vscNull();
		}

		$aRegexes	= array_keys($aMaps);
		$aMatches 	= array();

		$sUri = $this->getRequest()->getUri(true); // get it as a urldecoded string
		$aMatches = array();
		foreach ($aRegexes as $sRegex) {
			$sFullRegex = '#' . str_replace('#', '\#', $sRegex). '#iu'; // i for insensitive, u for utf8
			try {
				$iMatch			= preg_match_all($sFullRegex,  $sUri, $aMatches, PREG_SET_ORDER);
			} catch (vscExceptionError $e) {
				$f = new vscExceptionError(
					$e->getMessage(). '<br/> Offending regular expression: <span style="font-weight:normal">'. $sFullRegex . '</span>',
					$e->getCode());
				throw $f;
			}
			if ($iMatch) {
				$aMatches = array_shift($aMatches);
				$aMatches = array_slice($aMatches, 1);

				/* @var $oProcessorMapping vscMappingA */
				$oProcessorMapping  = $aMaps[$sRegex];
				$oProcessorMapping->setTaintedVars($aMatches);
				$oProcessorMapping->setUrl ($sUri);
				return $oProcessorMapping;
			}
		}
		return new vscNull();
	}

	public function getCurrentModuleMap () {
		return $this->getCurrentProcessorMap()->getModuleMap();
	}

	public function getCurrentProcessorMap () {
		return $this->getCurrentMap($this->getSiteMap()->getMaps());
	}

	public function getCurrentControllerMap () {
		$oCurrentModule = $this->getCurrentModuleMap();
		$oProcessorMap	= $this->getCurrentProcessorMap();
		$oModuleMap		= $oProcessorMap->getModuleMap();
		$aMaps 			= $oProcessorMap->getControllerMaps();

		// merging all controller maps found in the processor map's parent modules
		while ($oModuleMap instanceof vscMappingA) {
			$aMaps = array_merge ($oModuleMap->getControllerMaps(), $aMaps);
			$oModuleMap = $oModuleMap->getModuleMap();
		}

		return $this->getCurrentMap($aMaps);
	}

	/**
	 * @return vscFrontControllerA
	 */
	public function getFrontController () {
		if (!($this->oController instanceof vscFrontControllerA)) {
			$oControllerMapping	= $this->getCurrentControllerMap();

			if (!($oControllerMapping instanceof vscMappingA)) {
				// this mainly means nothing was matched to our url, or no mappings exist
				$oControllerMapping = new vscControllerMap(VSC_RES_PATH . 'application/controllers/vscxhtmlcontroller.class.php', '');
			}

			$sPath 	= $oControllerMapping->getPath();

			if ($this->getSiteMap()->isValidObject ($sPath)) {
				include ($sPath);

				$sControllerName = vscSiteMapA::getClassName($sPath);

				/* @var $oFront vscFrontControllerA */
				$this->oController = new $sControllerName();
				// adding the map to the controller, allows it to add resources (styles,scripts) from inside it
				$this->oController->setMap ($oControllerMapping);
			}
		}
//		d ($oControllerMapping);
		return $this->oController;
	}

	/**
	 * (non-PHPdoc)
	 * @see lib/presentation/dispatchers/vscDispatcherA#getProcessController()
	 * @return vscProcessorA
	 */
	public function getProcessController () {
		if (!($this->oProcessor instanceof vscProcessorA)) {
			$oProcessorMapping	= $this->getCurrentProcessorMap();
			if ($oProcessorMapping instanceof vscNull) {
				// this mainly means nothing was matched to our url, or no mappings exist, so we're falling back to 404
				$oProcessorMapping	= new vscProcessorMap(VSC_RES_PATH . 'application/processors/vsc404processor.class.php', '');
				$oProcessorMapping->setTemplatePath(VSC_RES_PATH . 'templates');
				$oProcessorMapping->setTemplate('404.php');
			}

			$sPath = $oProcessorMapping->getPath();

			try {
				if ($this->getSiteMap()->isValidObject ($sPath) ) {
					// dirty import of the module folder and important subfolders
					$sModuleName = $oProcessorMapping->getModuleName();
					if (is_dir($oProcessorMapping->getModulePath()) && !$oProcessorMapping->isStatic()) {
						import ($oProcessorMapping->getModulePath());
						try {
							import ($sModuleName);
							import ('application');
							import ('domain');
							import ('presentation');
						} catch (vscExceptionPath $e) {
							// ooopps
						}
					}
					include ($sPath);

					$sProcessorName = vscSiteMapA::getClassName($sPath);
					/* @var $oProcessor vscProcessorA */
					$this->oProcessor = new $sProcessorName();
				} elseif ($this->getSiteMap()->isValidStatic ($sPath) ) {
					// static stuff
					$this->oProcessor = new vscStaticFileProcessor();
					$this->oProcessor->setFilePath($sPath);
				} /*else {
					$this->oProcessor = new vsc404Processor();
				}*/
			} catch  (vscExceptionResponseRedirect $e) {
				// get the response
				$oResponse 			= new vscHttpRedirection ();
				$oResponse->setLocation ($e->getLocation());
				ob_end_flush();
				$sContent = $oResponse->outputHeaders();
			}
			// adding the map to the processor, allows it to easy add resources (styles,scripts) from inside it
			$this->oProcessor->setMap ($oProcessorMapping);

			// setting the variables defined in the processor into the tainted variables
			$this->getRequest()->setTaintedVars ($this->oProcessor->getLocalVars()); // FIXME!!!
		}

		return $this->oProcessor;
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
			$oMap = $this->getSiteMap()->map ('\A/', $sIncPath);
		} catch (vscExceptionSitemap $e) {
			// there was a faulty controller in the sitemap
			// this will probably result in a incomplete parsed sitemap tree
			throw ($e);
		}
	}

	public function getView () {}

	public function getTemplatePath () {
		$aMaps				= $this->getSiteMap ()->getMaps();
		$oProcessorMapping	= $this->getCurrentMap($aMaps);

		return $oProcessorMapping->getTemplate();
	}
}
