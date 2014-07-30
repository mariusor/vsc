<?php
/**
 * A controller for RESTful calls
 *
 * @package application/controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2013.10.04
 */
namespace vsc\application\controllers;

use vsc\application\processors\vscAuthenticatedProcessorI;
use vsc\application\processors\vscErrorProcessor;
use vsc\application\processors\vscRESTProcessorA;
use vsc\presentation\requests\vscHttpRequestA;
use vsc\presentation\requests\vscRESTRequest;
use vsc\presentation\responses\vscExceptionAuthenticationNeeded;
use vsc\presentation\responses\vscExceptionResponseError;
use vsc\presentation\responses\vscHttpResponse;
use vsc\application\sitemaps\vscControllerMap;
use vsc\presentation\responses\vscHttpResponseA;

class vscRESTController extends vscJsonController {
	/**
	 * @param vscHttpRequestA $oRequest
	 * @param vscRESTProcessorA $oProcessor
	 * @return vscHttpResponseA
	 * @throws \vsc\presentation\responses\vscExceptionResponse
	 * @throws \vsc\presentation\responses\vscExceptionResponseError
	 * @throws \vsc\presentation\views\vscExceptionView
	 * @throws vscExceptionResponseError
	 */
	public function getResponse (vscHttpRequestA $oRequest, $oProcessor = null) {
		$oResponse = new vscHttpResponse(); // this needs changing for REST stuff
		$oModel = null;
		/* @var $oMyMap vscControllerMap */
		$oMyMap	= $this->getMap();

		try {
			if ( !$oRequest->isGet() ) {
				if (!vscRESTRequest::isValid($oRequest)) {
					throw new vscExceptionResponseError ('Invalid request.', 415);
				}
				if ( vscRESTRequest::hasContentType() && !vscRESTRequest::validContentType($oRequest->getContentType()) ) {
					throw new vscExceptionResponseError ('Invalid request content type.', 415);
				}
			}

			/* @var $oProcessor vscRESTProcessorA */
			if (vscRESTProcessorA::isValid($oProcessor) && !$oProcessor->validRequestMethod($oRequest->getHttpMethod())) {
				throw new vscExceptionResponseError ('Invalid request method.', 405);
			}
			$oMap = $oProcessor->getMap();
			if ( $oMap->requiresAuthentication() ) {
				try {
					if ( $oProcessor instanceof vscAuthenticatedProcessorI ) {
						/* @var $oProcessor vscAuthenticatedProcessorI */
						if ( !$oRequest->hasAuthenticationData() ) {
							throw new vscExceptionAuthenticationNeeded ('This resource needs authentication');
						}
						if ( $oRequest->getAuthentication()->getType() & $oMap->getAuthenticationType() == $oRequest->getAuthentication()->getType()) {
							throw new vscExceptionAuthenticationNeeded ('Invalid authorization scheme. Supported schemes: ' . implode(', ', $oMap->getValidAuthenticationSchemas()));
						}
						if ( !$oProcessor->handleAuthentication ($oRequest->getAuthentication()) ) {
							throw new vscExceptionAuthenticationNeeded ('Invalid authentication data', 'testrealm');
						}
					} else {
						throw new vscExceptionAuthenticationNeeded ('This resource requires authentication but doesn\'t support any authorization scheme');
					}
				} catch (vscExceptionAuthenticationNeeded $e) {
					$oErrorProcessor = new vscErrorProcessor($e);

					$oResponse = parent::getResponse($oRequest, $oErrorProcessor);
					$oResponse->addHeader('WWW-Authorization', $e->getChallenge());
					return $oResponse;
				}
			}
		} catch (\Exception $e) {
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
		$oResponse = parent::getResponse($oRequest, $oProcessor);

		return $oResponse;
	}
}
