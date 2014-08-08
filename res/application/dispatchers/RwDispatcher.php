<?php
/**
 * Parses the current request into a valid Front Controller / Controller pair
 * @package presentation
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

use vsc\application\controllers\FrontControllerA;
use vsc\application\processors\ErrorProcessor;
use vsc\application\processors\ProcessorA;
use vsc\application\processors\StaticFileProcessor;
use vsc\application\sitemaps\ClassMap;
use vsc\application\sitemaps\ControllerMap;
use vsc\application\sitemaps\ExceptionSitemap;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ModuleMap;
use vsc\application\sitemaps\ProcessorMap;
use vsc\application\sitemaps\RwSiteMap;
use vsc\application\sitemaps\SiteMapA;
use vsc\presentation\requests\RwHttpRequest;
use vsc\presentation\responses\ExceptionResponseError;
use vsc\presentation\responses\ExceptionResponseRedirect;
use vsc\presentation\responses\HttpResponse;
use vsc\infrastructure\Null;
use vsc\ExceptionError;
use vsc\ExceptionPath;

class RwDispatcher extends HttpDispatcherA {
	/**
	 * @param array $aMaps
	 * @throws ExceptionError
	 * @returns ProcessorMap
	 */
	public function getCurrentMap ($aMaps) {
		if (!is_array($aMaps) || empty($aMaps)) {
			return new Null();
		}

		$aRegexes	= array_keys($aMaps);
		$aMatches 	= array();

		$sUri = $this->getRequest()->getUri(true); // get it as a urldecoded string
		$aMatches = array();
		foreach ($aRegexes as $sRegex) {
			$sFullRegex = '#' . str_replace('#', '\#', $sRegex). '#iu'; // i for insensitive, u for utf8
			try {
				$iMatch			= preg_match_all($sFullRegex, $sUri, $aMatches, PREG_SET_ORDER);
			} catch (ExceptionError $e) {
				$f = new ExceptionError(
					$e->getMessage(). '<br/> Offending regular expression: <span style="font-weight:normal">'. $sFullRegex . '</span>',
					$e->getCode());
				throw $f;
			}
			if ($iMatch) {
				$aMatches = array_shift($aMatches);
				$aMatches = array_slice($aMatches, 1);

				/* @var MappingA $oProcessorMapping */
				$oMapping  = $aMaps[$sRegex];
				$oMapping->setTaintedVars($aMatches);
				$oMapping->setUrl ($sUri);
				$oMapping->getModuleMap()->setUrl($sUri);
				return $oMapping;
			} else {

			}
		}
//		return new Null();
	}

	/**
	 * @returns ModuleMap
	 * @throws ExceptionSitemap
	 */
	public function getCurrentModuleMap () {
		if (ProcessorMap::isValid($this->getCurrentProcessorMap())) {
			return $this->getCurrentProcessorMap()->getModuleMap();
		} else {
			return $this->getSiteMap()->getCurrentModuleMap();
		}
	}

	/**
	 * @returns ProcessorMap
	 * @throws ExceptionSitemap
	 * @throws ExceptionError
	 */
	public function getCurrentProcessorMap () {
		return $this->getCurrentMap($this->getSiteMap()->getMaps());
	}

	/**
	 * @returns ControllerMap
	 * @throws ExceptionError
	 */
	public function getCurrentControllerMap () {
		$oProcessorMap	= $this->getCurrentProcessorMap();

		// check if the current processor has some set maps
		$aProcessorMaps = $oProcessorMap->getControllerMaps();
		$oCurrentMap	= $this->getCurrentMap($aProcessorMaps);
		if (ControllerMap::isValid($oCurrentMap) || ClassMap::isValid($oCurrentMap) ) {
			return $oCurrentMap;
		}

		// check the current module for maps
		$oCurrentModule = $this->getCurrentModuleMap();
		$aModuleMaps 	= $oCurrentModule->getControllerMaps();
		$oCurrentMap	= $this->getCurrentMap($aModuleMaps);
		if (ControllerMap::isValid($oCurrentMap) || ClassMap::isValid($oCurrentMap) ) {
			return $oCurrentMap;
		}

		// merging all controller maps found in the processor map's parent modules
		while (!ControllerMap::isValid($oCurrentMap)) {
			$oModuleMap		= $oCurrentModule->getModuleMap();
			$aMaps			= $oModuleMap->getControllerMaps();
			$oCurrentMap	= $this->getCurrentMap($aMaps);
			if ($oCurrentMap instanceof Null) {
				return $oCurrentMap;
			}
		}

		return $oCurrentMap;
	}

	/**
	 * @returns FrontControllerA
	 */
	public function getFrontController () {
		if (!FrontControllerA::isValid($this->oController)) {
			$oControllerMapping	= $this->getCurrentControllerMap();

//			if (!ControllerMap::isValid($oControllerMapping)) {
//				// this mainly means nothing was matched to our url, or no mappings exist
//				$oControllerMapping = new ControllerMap(VSC_RES_PATH . 'application/controllers/vscxhtmlcontroller.php', '');
//			}

			if (ControllerMap::isValid($oControllerMapping)) {
				$sPath = $oControllerMapping->getPath();
				if ($this->getSiteMap()->isValidObject($sPath)) {
					include($sPath);

					$sControllerName = SiteMapA::getClassName($sPath);
				}
			}
			if (ClassMap::isValid($oControllerMapping)) {
				$sControllerName = $sPath = $oControllerMapping->getPath();;
			}

			/* @var $this->oController vscFrontControllerA */
			$this->oController = new $sControllerName();
			if (FrontControllerA::isValid($this->oController)) {
				// adding the map to the controller, allows it to add resources (styles,scripts) from inside it
				$this->oController->setMap($oControllerMapping);
			}
		}
//		d ($oControllerMapping);
		return $this->oController;
	}

	/**
	 * (non-PHPdoc)
	 * @see lib/presentation/dispatchers/vscDispatcherA#getProcessController()
	 * @throws ExceptionSitemap
	 * @throws ExceptionResponseError
	 * @returns ProcessorA
	 */
	public function getProcessController () {
		if (!ProcessorA::isValid($this->oProcessor)) {
			$oProcessorMap	= $this->getCurrentProcessorMap();
			if (!ProcessorMap::isValid($oProcessorMap) && !ClassMap::isValid($oProcessorMap)) {
				// this mainly means nothing was matched to our url, or no mappings exist, so we're falling back to 404
				$oProcessorMap	= new ProcessorMap('\\vsc\\application\\processors\\NotFoundProcessor', '.*');
				$oProcessorMap->setTemplatePath(VSC_RES_PATH . 'templates');
				$oProcessorMap->setTemplate('404.php');
			}

			$sPath = $oProcessorMap->getPath();
			try {
				if ( $this->getSiteMap()->isValidObject ($sPath) || (stristr(basename($sPath), '.') === false && !is_file($sPath))) {
					// dirty import of the module folder and important subfolders
					$sModuleName = $oProcessorMap->getModuleName();
//					if ( is_dir ($oProcessorMap->getModulePath()) && !$oProcessorMap->isStatic() ) {
//						 \vsc\import ($oProcessorMap->getModulePath());
//						try {
//							import ($sModuleName);
//							\vsc\import ('application');
//							\vsc\import ('domain');
//							\vsc\import ('presentation');
//						} catch (ExceptionPath $e) {
//							// ooopps
//						}
//					}
					if ( stristr(basename($sPath), '.') === false && !is_file($sPath) ) {
						// namespaced class name
						$sProcessorName = $sPath;
					} elseif (is_file($sPath)) {
						try {
							include ($sPath);
						} catch (\Exception $e) {
							\vsc\_e($e);
						}
						$sProcessorName = SiteMapA::getClassName($sPath);
					}

					try {
						$this->oProcessor = new $sProcessorName();
					} catch (\Exception $e) {
						$this->oProcessor = new ErrorProcessor($e);
					}
				} elseif ($this->getSiteMap()->isValidStatic ($sPath) ) {
					// static stuff
					$this->oProcessor = new StaticFileProcessor();
					$this->oProcessor->setFilePath($sPath);
				} /*else {
					$this->oProcessor = new NotFoundProcessor();
				}*/

				if (ProcessorA::isValid($this->oProcessor)) {
					// adding the map to the processor, allows it to easy add resources (styles,scripts) from inside it
					$this->oProcessor->setMap ($oProcessorMap);

					// setting the variables defined in the processor into the tainted variables
					/** @var RwHttpRequest $oRawRequest */
					$oRawRequest = $this->getRequest();
					if (RwHttpRequest::isValid($oRawRequest)) {
						$oRawRequest->setTaintedVars ($this->oProcessor->getLocalVars()); // FIXME!!!
					}
				} else {
//					\vsc\d($sPath, $this->oProcessor);
//					\vsc\d($this->oProcessor);
					// broken URL
					throw new ExceptionResponseError('Broken URL', 400);
				}
			} catch  (ExceptionResponseRedirect $e) {
				// get the response
				$oResponse 			= new HttpResponse ();
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
	 * @throws ExceptionSitemap
	 * @return void
	 */
	public function loadSiteMap ($sIncPath) {
		// @FIXME: this needs to be refactored with some getters/settes
		$this->setSiteMap (new RwSiteMap());
		try {
			// hic sunt leones
			$oMap = $this->getSiteMap()->map ('\A/', $sIncPath);
		} catch (ExceptionSitemap $e) {
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
