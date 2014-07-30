<?php
/**
 * @package vsc_application
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.30
 */
namespace vsc\application\controllers;
vsc\import (VSC_LIB_PATH . 'application/processors');
vsc\import (VSC_LIB_PATH . 'presentation/responses');
vsc\import (VSC_RES_PATH . 'application/processors');
vsc\import (VSC_RES_PATH . 'domain/models');
abstract class vscFrontControllerA extends vscObject {
	/**
	 * @var string
	 */
	private $sTemplatePath;

	/**
	 * @var vscControllerA
	 */
	private $oCurrentMap;

	/**
	 * @var vscViewA
	 */
	private $oView;

	/**
	 * @return vscViewA
	 */
	abstract public function getDefaultView();

	/**
	 * @throws vscExceptionView
	 * @return vscControllerMap
	 */
	public function getMap () {
		if (vscControllerMap::isValid($this->oCurrentMap )) {
			return $this->oCurrentMap;
		} else {
			throw new vscExceptionView ('Make sure the current Controller map is correctly set.');
		}
	}

	/**
	 * @param vscControllerMap $oMap
	 */
	public function setMap (vscControllerMap $oMap) {
		$this->oCurrentMap = $oMap;
	}

	/**
	 * @param $sIncPath
	 * @throws vscExceptionController
	 */
	public function setTemplatePath ($sIncPath) {
		if (is_dir($sIncPath)) {
			$this->sTemplatePath = $sIncPath;
		} else {
			throw new vscExceptionController('The template path ['.$sIncPath.'] is not a valid folder.');
		}
	}

	/**
	 * @param vscHttpRequestA $oRequest
	 * @param vscProcessorA $oProcessor
	 * @throws vscExceptionPath
	 * @throws vscExceptionResponse
	 * @throws vscExceptionView
	 * @internal param vscViewA $oView
	 * @return vscHttpResponseA
	 */
	public function getResponse (vscHttpRequestA $oRequest, $oProcessor = null) {
		$oResponse = new vscHttpResponse(); // this needs changing for REST stuff
		$oModel = null;
		/* @var $oMyMap vscControllerMap */
		$oMyMap	= $this->getMap();

		if (vscProcessorA::isValid($oProcessor)) {
			try {
				$oProcessor->init();

				$oModel = $oProcessor->handleRequest($oRequest);
			} catch (vscExceptionResponseRedirect $e) {
				$oResponse->setStatus($e->getRedirectCode());
				$oResponse->setLocation ($e->getLocation());

				return $oResponse;
			} catch (Exception $e) {
				// we had error in the controller
				// @todo make more error processors
				if ( $e instanceof vscExceptionResponseError ) {
					$oResponse->setStatus($e->getErrorCode());
				}
				$oProcessor = new vscErrorProcessor($e);

				$oMyMap->setMainTemplatePath(VSC_RES_PATH . 'templates');
				$oMyMap->setMainTemplate('main.php');

				$oModel = $oProcessor->handleRequest($oRequest);
			}
		}
		if (vscErrorProcessor::isValid($oProcessor)) {
			$iCode = $oProcessor->getErrorCode();
			if (vscHttpResponseType::isValidStatus($iCode)) {
				$oResponse->setStatus($iCode);
			} else {
				$oResponse->setStatus(500);
			}
		} else {
			$oResponse->setStatus (200);
		}

		// we didn't set any special view
		// this means that the developer needs to provide his own views
		$oView	= $this->getView();
		$oMap = null;
		if (vscProcessorA::isValid($oProcessor) /* && !vscErrorProcessor::isValid($oProcessor) */) {
			/* @var $oMap vscProcessorMap */
			$oMap = $oProcessor->getMap();
			$oMap->merge($oMyMap);
			$oProcessorResponse = $oMap->getResponse();

			if (vscHttpResponseA::isValid($oProcessorResponse)) {
				$oResponse = $oProcessorResponse;
			}

			// setting the processor map
			$oView->setMap ($oMap);
		}

		if ((vscProcessorMap::isValid($oMap) && !$oMap->isStatic() && !$oMyMap->isStatic()) && vscControllerMap::isValid($oMyMap)) {
			$oView->setMainTemplate($oMyMap->getMainTemplatePath() . DIRECTORY_SEPARATOR . $oView->getViewFolder() . DIRECTORY_SEPARATOR . $oMyMap->getMainTemplate());
		}

		if (!vscModelA::isValid($oModel)) {
			$oModel = new vscEmptyModel();
			if (!vscProcessorMap::isValid ($oMap) || $oMap->getTitle() == '') {
				$oModel->setPageTitle ('Warning');
			}
			$oModel->setPageContent ('Warning: the processor didn\'t return a valid model. This is probably an error');
		}
		$oView->setModel($oModel);

		$oResponse->setView ($oView);
		if ( vscMappingA::isValid($oMap) ) {
			$aHeaders = $oMap->getHeaders ();
			if ( count ( $aHeaders ) > 0 ) {
				foreach ( $aHeaders as $sName => $sHeader ) {
					$oResponse->addHeader ( $sName, $sHeader );
				}
			}
		}
		return $oResponse;
	}

	/**
	 * @return vscViewA
	 * @throws vscExceptionView
	 */
	public function getView () {
		$sViewPath = $this->getMap()->getViewPath();
		if (!vscViewA::isValid($this->oView)) {
			if (is_null($sViewPath)) {
				$this->oView = $this->getDefaultView();
			} else {
				//$sViewPath	= dirname($sViewPath);
				include ($sViewPath);

				$sClassName	= vscSiteMapA::getClassName($sViewPath);

				if (!empty($sClassName)) {
					$this->oView = new $sClassName();
				}
			}
		}
		return $this->oView;
	}
}
