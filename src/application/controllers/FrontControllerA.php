<?php
/**
 * @package application
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.30
 */
namespace vsc\application\controllers;

use vsc\application\processors\ErrorProcessor;
use vsc\application\processors\ProcessorA;
use vsc\application\sitemaps\ClassMap;
use vsc\application\sitemaps\ContentTypeMappingInterface;
use vsc\application\sitemaps\MappingA;
use vsc\domain\models\EmptyModel;
use vsc\domain\models\ErrorModel;
use vsc\domain\models\ModelA;
use vsc\infrastructure\BaseObject;
use vsc\infrastructure\vsc;
use vsc\presentation\responses\ExceptionResponseRedirect;
use vsc\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseType;
use vsc\presentation\views\ExceptionView;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\views\ViewA;
use vsc\ExceptionPath;
use vsc\presentation\responses\ExceptionResponse;

abstract class FrontControllerA extends BaseObject {
	/**
	 * @var string
	 */
	private $sTemplatePath;

	/**
	 * @var ContentTypeMappingInterface
	 */
	private $oCurrentMap;

	/**
	 * @var ViewA
	 */
	private $oView;

	/**
	 * @returns ViewA
	 */
	abstract public function getDefaultView();

	/**
	 * @throws ExceptionView
	 * @returns ClassMap
	 */
	public function getMap() {
		if (!ClassMap::isValid($this->oCurrentMap)) {
			$Mirror = new \ReflectionClass($this);
			$this->oCurrentMap = new ClassMap($Mirror->getName(), '.*');
		}
		return $this->oCurrentMap;
	}

	/**
	 * @param ContentTypeMappingInterface $oMap
	 */
	public function setMap(ContentTypeMappingInterface $oMap) {
		$this->oCurrentMap = $oMap;
	}

	/**
	 * @param $sIncPath
	 * @return bool
	 * @throws ExceptionController
	 */
	public function setTemplatePath($sIncPath) {
		if (is_dir($sIncPath)) {
			$this->sTemplatePath = $sIncPath;
			return true;
		} else {
			throw new ExceptionController('The template path [' . $sIncPath . '] is not a valid folder.');
		}
	}

	/**
	 * @param HttpRequestA $oRequest
	 * @param ProcessorA $oProcessor
	 * @return ViewA
	 * @throws ExceptionPath
	 */
	protected function loadView($oRequest, $oProcessor = null) {
		// we didn't set any special view
		// this means that the developer needs to provide his own views
		$oView = $this->getView();
		$oMyMap = $this->getMap();

		if (ProcessorA::isValid($oProcessor)) {
			$oProcessor->init();
			$oModel = $oProcessor->handleRequest($oRequest);
			/* @var ClassMap $oMap */
			$oMap = $oProcessor->getMap();
			if (MappingA::isValid($oMap)) {
				if (MappingA::isValid($oMyMap)) {
					$oMap->merge($oMyMap);
				}
			}
			// setting the processor map
			$oView->setMap($oMap);
			try {
				if ((ClassMap::isValid($oMap) && !$oMap->isStatic() && !$oMyMap->isStatic()) && ClassMap::isValid($oMyMap)) {
					$oView->setMainTemplate(
						$oMyMap->getMainTemplatePath() .
						$oView->getViewFolder() . DIRECTORY_SEPARATOR .
						$oMyMap->getMainTemplate()
					);
				}
			} catch (ExceptionPath $e) {
				// fallback to html5
				// @todo verify main template path and main template exist
				$oView->setMainTemplate($oMyMap->getMainTemplatePath() . DIRECTORY_SEPARATOR . 'html5' . DIRECTORY_SEPARATOR . $oMyMap->getMainTemplate());
			}
			if (!ModelA::isValid($oModel)) {
				$oModel = new EmptyModel();
				if (!ClassMap::isValid($oMap) || $oMap->getTitle() == '') {
					$oModel->setPageTitle('Warning');
				}
				$oModel->setPageContent('Warning: the processor didn\'t return a valid model. This is probably an error');
			}
			$oView->setModel($oModel);
		}
		return $oView;
	}

	/**
	 * @param HttpRequestA $oRequest
	 * @param ProcessorA $oProcessor
	 * @throws ExceptionPath
	 * @throws ExceptionResponse
	 * @throws ExceptionView
	 * @returns HttpResponseA
	 */
	public function getResponse(HttpRequestA $oRequest, $oProcessor = null) {
		$oResponse = vsc::getEnv()->getHttpResponse();
		if ($oResponse->getStatus() == 0) {
			$oResponse->setStatus(HttpResponseType::OK);
		}

		try {
			$oView = $this->loadView($oRequest, $oProcessor);
			$oResponse->setView($oView);
			if (ProcessorA::isValid($oProcessor)) {
				$oMap = $oProcessor->getMap();
				if (MappingA::isValid($oMap)) {
					$aHeaders = $oMap->getHeaders();
					if (count($aHeaders) > 0) {
						foreach ($aHeaders as $sName => $sHeader) {
							$oResponse->addHeader($sName, $sHeader);
						}
					}
					$iProcessorSetStatus = $oMap->getResponseStatus();
					if (HttpResponseType::isValidStatus($iProcessorSetStatus)) {
						$oResponse->setStatus($iProcessorSetStatus);
					}
				}
			}
			return $oResponse;
		} catch (ExceptionResponseRedirect $e) {
			$oResponse->setStatus($e->getRedirectCode());
			$oResponse->setLocation($e->getLocation());

			return $oResponse;
		} catch (\Exception $e) {
			// we had error in the controller
			// @todo make more error processors
			return $this->getErrorResponse($e, $oRequest);
		}
	}

	/**
	 * @param \Exception $e
	 * @param HttpRequestA $oRequest
	 * @return HttpResponseA
	 * @throws ExceptionPath
	 * @throws ExceptionResponse
	 */
	public function getErrorResponse(\Exception $e, $oRequest = null) {
		$oResponse = vsc::getEnv()->getHttpResponse();

		$oProcessor = new ErrorProcessor($e);

		/* @var ClassMap $oMyMap */
		$oMyMap = $this->getMap();

		$oMyMap->setMainTemplatePath(VSC_SRC_PATH . 'templates');
		$oMyMap->setMainTemplate('main.php');

		if (!HttpRequestA::isValid($oRequest)) {
			$oRequest = vsc::getEnv()->getHttpRequest();
		}

		/** @var ErrorModel $oModel */
		$oModel = $oProcessor->handleRequest($oRequest);

		$iCode = $oModel->getHttpStatus();
		if (HttpResponseType::isValidStatus($iCode)) {
			$oResponse->setStatus($iCode);
		} else {
			$oResponse->setStatus(500);
		}

		// we didn't set any special view
		// this means that the developer needs to provide his own views
		$oView = $this->getView();

		/* @var ClassMap $oMap */
		$oMap = $oProcessor->getMap();
		$oMap->merge($oMyMap);
		$oProcessorResponse = $oMap->getResponse();

		if (HttpResponseA::isValid($oProcessorResponse)) {
			$oResponse = $oProcessorResponse;
		}

		// setting the processor map
		$oView->setMap($oMap);
		if (ClassMap::isValid($oMyMap)) {
			$oView->setMainTemplate($oMyMap->getMainTemplatePath() . DIRECTORY_SEPARATOR . $oView->getViewFolder() . DIRECTORY_SEPARATOR . $oMyMap->getMainTemplate());
		}
		$oView->setModel($oModel);

		$oResponse->setView($oView);

		$aHeaders = $oMap->getHeaders();
		if (count($aHeaders) > 0) {
			foreach ($aHeaders as $sName => $sHeader) {
				$oResponse->addHeader($sName, $sHeader);
			}
		}

		return $oResponse;
	}

	/**
	 * @returns ViewA
	 * @throws ExceptionView
	 */
	public function getView() {
		if (ViewA::isValid($this->oView)) {
			return $this->oView;
		}
		$oMapView = $this->getMap()->getView();
		if (ViewA::isValid($oMapView)) {
			return $oMapView;
		}
		$this->oView = $this->getDefaultView();
		return $this->oView;
	}
}
