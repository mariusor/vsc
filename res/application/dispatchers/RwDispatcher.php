<?php
/**
 * Parses the current request into a valid Front Controller / Controller pair
 * @package presentation
 * @subpackage dispatchers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.09.24
 */
namespace vsc\application\dispatchers;

use vsc\application\controllers\FrontControllerA;
use vsc\application\controllers\Html5Controller;
use vsc\application\processors\ErrorProcessor;
use vsc\application\processors\NotFoundProcessor;
use vsc\application\processors\ProcessorA;
use vsc\application\processors\StaticFileProcessor;
use vsc\application\sitemaps\ClassMap;
use vsc\application\sitemaps\ErrorControllerMap;
use vsc\application\sitemaps\ErrorProcessorMap;
use vsc\application\sitemaps\ExceptionSitemap;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ModuleMap;
use vsc\application\sitemaps\RootMap;
use vsc\infrastructure\vsc;
use vsc\presentation\requests\RwHttpRequest;
use vsc\presentation\responses\ExceptionResponseError;
use vsc\presentation\responses\ExceptionResponseRedirect;
use vsc\ExceptionError;
use vsc\presentation\responses\HttpResponseType;

class RwDispatcher extends HttpDispatcherA {
	/**
	 * @param array $aMaps
	 * @throws ExceptionError
	 * @returns ClassMap
	 */
	static protected function getCurrentMap($aMaps, $sUri = null) {
		if (!is_array($aMaps) || empty($aMaps)) {
			return new ErrorProcessorMap();
		}

		if (is_null($sUri)) {
			$sUri = vsc::getEnv()->getHttpRequest()->getUri(true);
		}
		$aRegexes = array_keys($aMaps);

		$aMatches = array();
		foreach ($aRegexes as $sRegex) {
			$sFullRegex = '#' . str_replace('#', '\#', $sRegex) . '#iu'; // i for insensitive, u for utf8
			try {
				$iMatch = preg_match_all($sFullRegex, $sUri, $aMatches, PREG_SET_ORDER);
			} catch (ExceptionError $e) {
				$f = new ExceptionError(
					$e->getMessage() . '<br/> Offending regular expression: <span style="font-weight:normal">' . $sFullRegex . '</span>',
					$e->getCode());
				throw $f;
			}
			if ($iMatch) {
				$aMatches = array_shift($aMatches);
				$aMatches = array_slice($aMatches, 1);

				/* @var MappingA $oMapping */
				$oMapping = $aMaps[$sRegex];
				$oMapping->setTaintedVars($aMatches);
				$oMapping->setUrl($sUri);
				$oMapping->getModuleMap()->setUrl($sUri);
				return $oMapping;
			}
		}
		return null;
	}

	/**
	 * @returns ModuleMap
	 * @throws ExceptionSitemap
	 */
	public function getCurrentModuleMap() {
		$oProcessorMap = $this->getCurrentProcessorMap();
		if (ClassMap::isValid($oProcessorMap)) {
			return $this->getCurrentProcessorMap()->getModuleMap();
		} else {
			return $this->getSiteMap()->getCurrentModuleMap();
		}
	}

	/**
	 * @returns ClassMap
	 * @throws ExceptionSitemap
	 * @throws ExceptionError
	 */
	public function getCurrentProcessorMap() {
		$oProcessorMap = self::getCurrentMap($this->getSiteMap()->getMaps());
		if (!ClassMap::isValid($oProcessorMap)) {
			$oProcessorMap = new ErrorProcessorMap(NotFoundProcessor::class);
		}
		return $oProcessorMap;
	}

	/**
	 * @returns ClassMap
	 * @throws ExceptionError
	 */
	public function getCurrentControllerMap() {
 		$oProcessorMap = $this->getCurrentProcessorMap();

		$oCurrentMap = null;
		// check if the current processor has some set maps
		$aProcessorCtrlMaps = $oProcessorMap->getControllerMaps();
		if (count($aProcessorCtrlMaps) > 0) {
			$oCurrentMap = self::getCurrentMap($aProcessorCtrlMaps);
			if (ClassMap::isValid($oCurrentMap) && !ErrorControllerMap::isValid($oCurrentMap)) {
				return $oCurrentMap;
			}
		}

		$oCurrentModule = $oProcessorMap->getModuleMap();
		// merging all controller maps found in the processor map's parent modules
		do {
			// check the current module for maps
			$aModuleCtrlMaps = $oCurrentModule->getControllerMaps();
			if (count($aModuleCtrlMaps) > 0) {
				$oCurrentMap = self::getCurrentMap($aModuleCtrlMaps);
			}
			$oCurrentModule = $oCurrentModule->getModuleMap();
		} while (!ClassMap::isValid($oCurrentMap));

		return $oCurrentMap;
	}

	/**
	 * @throws \vsc\application\sitemaps\ExceptionSitemap
	 * @throws \vsc\presentation\responses\ExceptionResponseError
	 * @returns FrontControllerA
	 */
	public function getFrontController() {
		if (!FrontControllerA::isValid($this->oController)) {
			$oControllerMapping = $this->getCurrentControllerMap();

			if (ClassMap::isValid($oControllerMapping)) {
				$sControllerName = $oControllerMapping->getPath();
			}

			if (empty($sControllerName)) {
				throw new ExceptionResponseError('Could not find the correct front controller', HttpResponseType::NOT_FOUND);
			}

			/* @var $this->oController FrontControllerA */
			$this->oController = new $sControllerName();
			if (FrontControllerA::isValid($this->oController)) {
				// adding the map to the controller, allows it to add resources (styles,scripts) from inside it
				$this->oController->setMap($oControllerMapping);
			}
		}

		return $this->oController;
	}

	/**
	 * (non-PHPdoc)
	 * @see vsc/presentation/dispatchers/HttpDispatcherA::getProcessController()
	 * @throws ExceptionSitemap
	 * @throws ExceptionResponseError
	 * @returns ProcessorA
	 */
	public function getProcessController() {
		if (!ProcessorA::isValid($this->oProcessor)) {
			$oProcessorMap = $this->getCurrentProcessorMap();
			if (!ClassMap::isValid($oProcessorMap)) {
				// this mainly means nothing was matched to our url, or no mappings exist, so we're falling back to 404
				$oProcessorMap = new ErrorProcessorMap(NotFoundProcessor::class, '.*');
				$oProcessorMap->setTemplatePath(VSC_RES_PATH . 'templates');
				$oProcessorMap->setTemplate('404.php');
			}

			$sPath = $oProcessorMap->getPath();
			try {
				if (ClassMap::isValidMap($sPath) || (stristr(basename($sPath), '.') === false && !is_file($sPath))) {

					try {
						if (class_exists($sPath)) {
							$this->oProcessor = new $sPath();
						} else {
							$this->oProcessor = new NotFoundProcessor();
						}
					} catch (\Exception $e) {
						$this->oProcessor = new ErrorProcessor($e);
					}
				} elseif ($this->getSiteMap()->isValidStaticPath($sPath)) {
					// static stuff
					$this->oProcessor = new StaticFileProcessor();
					$this->oProcessor->setFilePath($sPath);
				} /*else {
					$this->oProcessor = new NotFoundProcessor();
				}*/

				if (ProcessorA::isValid($this->oProcessor)) {
					if (!(ErrorProcessor::isValid($this->oProcessor) && MappingA::isValid($this->oProcessor->getMap()))) {
						// @TODO: this should be a MappingA->merge() when the processor already has a map
						$this->oProcessor->setMap($oProcessorMap);
					}

					// setting the variables defined in the processor into the tainted variables
					/** @var RwHttpRequest $oRawRequest */
					$oRawRequest = $this->getRequest();
					if (RwHttpRequest::isValid($oRawRequest)) {
						$oRawRequest->setTaintedVars($this->oProcessor->getLocalVars()); // FIXME!!!
					}
				} else {
					// broken URL
					throw new ExceptionResponseError('Broken URL', 400);
				}
			} catch (ExceptionResponseRedirect $e) {
				// get the response
				$oResponse = vsc::getEnv()->getHttpResponse();
				$oResponse->setLocation($e->getLocation());
				ob_end_flush();
				$oResponse->outputHeaders();
			}
		}

		return $this->oProcessor;
	}

	/**
	 *
	 * @param string $sIncPath
	 * @throws \Exception
	 * @throws ExceptionSitemap
	 * @return boolean
	 */
	public function loadSiteMap($sIncPath) {
		try {
			// hic sunt leones
			/** @var ModuleMap $oMap */
			$oMap = $this->getSiteMap()->map('\A/', $sIncPath);
			if (count($oMap->getControllerMaps()) == 0) {
				$oMap->map('\A.*\Z', Html5Controller::class);
			}
		} catch (ExceptionSitemap $e) {
			// there was a faulty controller in the sitemap
			// this will probably result in a incomplete parsed sitemap tree
			throw ($e);
		}
		return true;
	}

	public function getView() {}

	public function getTemplatePath() {
		$aMaps = $this->getSiteMap()->getMaps();
		$oProcessorMap = self::getCurrentMap($aMaps);

		if (ClassMap::isValid($oProcessorMap)) {
			$sPath = $oProcessorMap->getTemplatePath();
		} else {
			$sPath = $this->getCurrentControllerMap()->getTemplatePath();
		}
		return $sPath;
	}
}
