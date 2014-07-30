<?php
/**
 * Parses the current request into a valid Front Controller / Controller pair
 * @package vsc_presentation
 * @subpackage dispatchers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.09.24
 */
namespace vsc\application\dispatchers;

// \vsc\import ('application/controllers');
// \vsc\import ('application/processors');
// \vsc\import ('presentation/responses');
// \vsc\import ('domain/models');
// \vsc\import ('exceptions');

use vsc\application\controllers\vscFrontControllerA;
use vsc\application\processors\vscErrorProcessor;
use vsc\application\processors\vscProcessorA;
use vsc\application\processors\vscStaticFileProcessor;
use vsc\application\sitemaps\vscControllerMap;
use vsc\application\sitemaps\vscExceptionSitemap;
use vsc\application\sitemaps\vscModuleMap;
use vsc\application\sitemaps\vscProcessorMap;
use vsc\application\sitemaps\vscRwSiteMap;
use vsc\application\sitemaps\vscSiteMapA;
use vsc\presentation\requests\vscRwHttpRequest;
use vsc\presentation\responses\vscExceptionResponseError;
use vsc\presentation\responses\vscExceptionResponseRedirect;
use vsc\presentation\responses\vscHttpResponse;
use vsc\infrastructure\vscNull;
use vsc\vscExceptionError;
use vsc\vscExceptionPath;

class vscRwDispatcher extends vscHttpDispatcherA {
	/**
	 * @param array $aMaps
	 * @throws vscExceptionError
	 * @return vscProcessorMap
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

				/* @var $oProcessorMapping vscProcessorMap */
				$oProcessorMapping  = $aMaps[$sRegex];
				$oProcessorMapping->setTaintedVars($aMatches);
				$oProcessorMapping->setUrl ($sUri);
				$oProcessorMapping->getModuleMap()->setUrl($sUri);
				return $oProcessorMapping;
			}
		}
		return new vscNull();
	}

	/**
	 * @return vscModuleMap
	 * @throws vscExceptionSitemap
	 */
	public function getCurrentModuleMap () {
		if (vscProcessorMap::isValid($this->getCurrentProcessorMap())) {
			return $this->getCurrentProcessorMap()->getModuleMap();
		} else {
			return $this->getSiteMap()->getCurrentModuleMap();
		}
	}

	/**
	 * @return vscProcessorMap
	 * @throws vscExceptionSitemap
	 * @throws vscExceptionError
	 */
	public function getCurrentProcessorMap () {
		return $this->getCurrentMap($this->getSiteMap()->getMaps());
	}

	/**
	 * @return vscControllerMap
	 * @throws vscExceptionError
	 */
	public function getCurrentControllerMap () {
		$oProcessorMap	= $this->getCurrentProcessorMap();

		// check if the current processor has some set maps
		$aProcessorMaps = $oProcessorMap->getControllerMaps();
		$oCurrentMap	= $this->getCurrentMap($aProcessorMaps);
		if (vscControllerMap::isValid($oCurrentMap)){
			return $oCurrentMap;
		}

		// check the current module for maps
		$oCurrentModule = $this->getCurrentModuleMap();
		$aModuleMaps 	= $oCurrentModule->getControllerMaps();
		$oCurrentMap	= $this->getCurrentMap($aModuleMaps);
		if (vscControllerMap::isValid($oCurrentMap)){
			return $oCurrentMap;
		}

		// merging all controller maps found in the processor map's parent modules
		while (!vscControllerMap::isValid($oCurrentMap)) {
			$oModuleMap		= $oCurrentModule->getModuleMap();
			$aMaps			= $oModuleMap->getControllerMaps();
			$oCurrentMap	= $this->getCurrentMap($aMaps);
			if ($oCurrentMap instanceof vscNull) {
				return $oCurrentMap;
			}
		}

		return $oCurrentMap;
	}

	/**
	 * @return vscFrontControllerA
	 */
	public function getFrontController () {
		if (!vscFrontControllerA::isValid($this->oController)) {
			$oControllerMapping	= $this->getCurrentControllerMap();

			if (!vscControllerMap::isValid($oControllerMapping)) {
				// this mainly means nothing was matched to our url, or no mappings exist
				$oControllerMapping = new vscControllerMap(VSC_RES_PATH . 'application/controllers/vscxhtmlcontroller.php', '');
			}

			$sPath 	= $oControllerMapping->getPath();

			if ($this->getSiteMap()->isValidObject ($sPath)) {
				include ($sPath);

				$sControllerName = vscSiteMapA::getClassName($sPath);

				/* @var $this->oController vscFrontControllerA  */
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
	 * @throws vscExceptionSitemap
	 * @throws vscExceptionResponseError
	 * @return vscProcessorA
	 */
	public function getProcessController () {
		if (!vscProcessorA::isValid($this->oProcessor)) {
			$oProcessorMap	= $this->getCurrentProcessorMap();
			if (!vscProcessorMap::isValid($oProcessorMap)) {
				// this mainly means nothing was matched to our url, or no mappings exist, so we're falling back to 404
				$oProcessorMap	= new vscProcessorMap(VSC_RES_PATH . 'application/processors/vsc404processor.class.php', '');
				$oProcessorMap->setTemplatePath(VSC_RES_PATH . 'templates');
				$oProcessorMap->setTemplate('404.php');
			}

			$sPath = $oProcessorMap->getPath();
			try {
				if ($this->getSiteMap()->isValidObject ($sPath) ) {
					// dirty import of the module folder and important subfolders
					$sModuleName = $oProcessorMap->getModuleName();
					if ( is_dir ($oProcessorMap->getModulePath()) && !$oProcessorMap->isStatic() ) {
						// \vsc\import ($oProcessorMap->getModulePath());
						try {
//							import ($sModuleName);
							// \vsc\import ('application');
							// \vsc\import ('domain');
							// \vsc\import ('presentation');
						} catch (vscExceptionPath $e) {
							// ooopps
						}
					}
					include ($sPath);

					try {
						$sProcessorName = vscSiteMapA::getClassName($sPath);
						$this->oProcessor = new $sProcessorName();
					} catch (\Exception $e) {
						$this->oProcessor = new vscErrorProcessor($e);
					}
				} elseif ($this->getSiteMap()->isValidStatic ($sPath) ) {
					// static stuff
					$this->oProcessor = new vscStaticFileProcessor();
					$this->oProcessor->setFilePath($sPath);
				} /*else {
					$this->oProcessor = new vsc404Processor();
				}*/

				if (vscProcessorA::isValid($this->oProcessor)) {
					// adding the map to the processor, allows it to easy add resources (styles,scripts) from inside it
					$this->oProcessor->setMap ($oProcessorMap);

					// setting the variables defined in the processor into the tainted variables
					/** @var vscRwHttpRequest $oRawRequest */
					$oRawRequest = $this->getRequest();
					if (vscRwHttpRequest::isValid($oRawRequest)) {
						$oRawRequest->setTaintedVars ($this->oProcessor->getLocalVars()); // FIXME!!!
					}
				} else {
					// broken URL
					throw new vscExceptionResponseError('Broken URL', 400);
				}
			} catch  (vscExceptionResponseRedirect $e) {
				// get the response
				$oResponse 			= new vscHttpResponse ();
				$oResponse->setLocation ($e->getLocation());
				ob_end_flush();
				$sContent = $oResponse->outputHeaders();
			}
		}

		return $this->oProcessor;
	}

	/**
	 *
	 * @param string $sIncPath
	 * @throws \Exception
	 * @throws vscExceptionSitemap
	 * @return void
	 */
	public function loadSiteMap ($sIncPath) {
		// @FIXME: this needs to be refactored with some getters/settes
		$this->setSiteMap (new vscRwSiteMap());
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
		$oProcessorMap	= $this->getCurrentMap($aMaps);

		return $oProcessorMap->getTemplate();
	}
}
