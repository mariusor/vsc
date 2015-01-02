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
use vsc\application\sitemaps\ControllerMap;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ProcessorMap;
use vsc\domain\models\EmptyModel;
use vsc\domain\models\ErrorModel;
use vsc\domain\models\ModelA;
use vsc\infrastructure\Object;
use vsc\infrastructure\vsc;
use vsc\presentation\responses\ExceptionResponseRedirect;
use vsc\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseType;
use vsc\presentation\views\ExceptionView;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\views\ViewA;
use vsc\ExceptionPath;
use vsc\presentation\responses\ExceptionResponse;

abstract class FrontControllerA extends Object {
	/**
	 * @var string
	 */
	private $sTemplatePath;

	/**
	 * @var ControllerMap
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
	 * @returns ControllerMap
	 */
	public function getMap () {
		if (!ControllerMap::isValid($this->oCurrentMap) && !ClassMap::isValid($this->oCurrentMap)) {
			$Mirror = new \ReflectionClass($this);
			$this->oCurrentMap = new ClassMap($Mirror->getName(), '.*');
		}
		return $this->oCurrentMap;
	}

	/**
	 * @param MappingA $oMap
	 */
	public function setMap (MappingA $oMap) {
		$this->oCurrentMap = $oMap;
	}

	/**
	 * @param $sIncPath
	 * @return bool
	 * @throws ExceptionController
	 */
	public function setTemplatePath ($sIncPath) {
		if (is_dir($sIncPath)) {
			$this->sTemplatePath = $sIncPath;
			return true;
		} else {
			throw new ExceptionController('The template path ['.$sIncPath.'] is not a valid folder.');
		}
	}

	/**
	 * @param HttpRequestA $oRequest
	 * @param ProcessorA $oProcessor
	 * @throws ExceptionPath
	 * @throws ExceptionResponse
	 * @throws ExceptionView
	 * @returns HttpResponseA
	 */
	public function getResponse (HttpRequestA $oRequest, $oProcessor = null) {
		$oResponse = vsc::getEnv()->getHttpResponse();
		$oModel = null;
		/* @var ControllerMap $oMyMap */
		$oMyMap	= $this->getMap();

		if (ProcessorA::isValid($oProcessor)) {
			try {
				$oProcessor->init();

				$oModel = $oProcessor->handleRequest($oRequest);
			} catch (ExceptionResponseRedirect $e) {
				$oResponse->setStatus($e->getRedirectCode());
				$oResponse->setLocation ($e->getLocation());

				return $oResponse;
			} catch (\Exception $e) {
				// we had error in the controller
				// @todo make more error processors
				return $this->getErrorResponse($e);
			}
		}
		if ($oResponse->getStatus() == 0) {
			$oResponse->setStatus (HttpResponseType::OK);
		}

		// we didn't set any special view
		// this means that the developer needs to provide his own views
		$oView	= $this->getView();
		$oMap = null;
		if (ProcessorA::isValid($oProcessor) /* && !ErrorProcessor::isValid($oProcessor) */) {
			/* @var ProcessorMap $oMap */
			$oMap = $oProcessor->getMap();
			$oMap->merge($oMyMap);
			$oProcessorResponse = $oMap->getResponse();

			if (HttpResponseA::isValid($oProcessorResponse)) {
				$oResponse = $oProcessorResponse;
			}

			// setting the processor map
			$oView->setMap ($oMap);
		}

		try {
			if (((ProcessorMap::isValid($oMap) || ClassMap::isValid($oMap)) && !$oMap->isStatic() && !$oMyMap->isStatic()) && (ControllerMap::isValid($oMyMap) || ClassMap::isValid($oMyMap))) {
				$oView->setMainTemplate($oMyMap->getMainTemplatePath() . DIRECTORY_SEPARATOR . $oView->getViewFolder() . DIRECTORY_SEPARATOR . $oMyMap->getMainTemplate());
			}
		} catch (ExceptionPath $e) {
			// fallback to html5
			// @todo verify main template path and main template exist
			$oView->setMainTemplate($oMyMap->getMainTemplatePath() . DIRECTORY_SEPARATOR . 'html5' . DIRECTORY_SEPARATOR . $oMyMap->getMainTemplate());
		}

		if (!ModelA::isValid($oModel)) {
			$oModel = new EmptyModel();
			if (!ProcessorMap::isValid ($oMap) || $oMap->getTitle() == '') {
				$oModel->setPageTitle ('Warning');
			}
			$oModel->setPageContent ('Warning: the processor didn\'t return a valid model. This is probably an error');
		}
		$oView->setModel($oModel);

		$oResponse->setView ($oView);
		if ( MappingA::isValid($oMap) ) {
			$aHeaders = $oMap->getHeaders ();
			if ( count ( $aHeaders ) > 0 ) {
				foreach ( $aHeaders as $sName => $sHeader ) {
					$oResponse->addHeader ( $sName, $sHeader );
				}
			}
			$iProcessorSetStatus = $oMap->getResponseStatus();
			if (HttpResponseType::isValidStatus($iProcessorSetStatus)) {
				$oResponse->setStatus($iProcessorSetStatus);
			}
		}
		return $oResponse;
	}

	public function getErrorResponse (\Exception $e) {
		$oResponse = vsc::getEnv()->getHttpResponse();

		$oProcessor = new ErrorProcessor($e);

		/* @var ControllerMap $oMyMap */
		$oMyMap	= $this->getMap();

		$oMyMap->setMainTemplatePath(VSC_RES_PATH . 'templates');
		$oMyMap->setMainTemplate('main.php');

		$oRequest = vsc::getEnv()->getHttpRequest();

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
		$oView	= $this->getView();

		/* @var ProcessorMap $oMap */
		$oMap = $oProcessor->getMap();
		$oMap->merge($oMyMap);
		$oProcessorResponse = $oMap->getResponse();

		if (HttpResponseA::isValid($oProcessorResponse)) {
			$oResponse = $oProcessorResponse;
		}

		// setting the processor map
		$oView->setMap ($oMap);

		if (ControllerMap::isValid($oMyMap)) {
			$oView->setMainTemplate($oMyMap->getMainTemplatePath() . DIRECTORY_SEPARATOR . $oView->getViewFolder() . DIRECTORY_SEPARATOR . $oMyMap->getMainTemplate());
		}
		$oView->setModel($oModel);

		$oResponse->setView ($oView);

		$aHeaders = $oMap->getHeaders ();
		if ( count ( $aHeaders ) > 0 ) {
			foreach ( $aHeaders as $sName => $sHeader ) {
				$oResponse->addHeader ( $sName, $sHeader );
			}
		}

		return $oResponse;
	}

	/**
	 * @returns ViewA
	 * @throws ExceptionView
	 */
	public function getView () {
		if (ViewA::isValid($this->oView)) {
			return $this->oView;
		}
		if (ViewA::isValid($this->getMap()->getView())) {
			return $this->getMap()->getView();
		}
		$this->oView = $this->getDefaultView();
		return $this->oView;
	}
}
