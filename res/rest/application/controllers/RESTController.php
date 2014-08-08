<?php
/**
 * A controller for RESTful calls
 *
 * @package application/controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2013.10.04
 */
namespace vsc\application\controllers;

use vsc\application\processors\AuthenticatedProcessorI;
use vsc\application\processors\ErrorProcessor;
use vsc\application\processors\RESTProcessorA;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\RESTRequest;
use vsc\presentation\responses\ExceptionAuthenticationNeeded;
use vsc\presentation\responses\ExceptionResponseError;
use vsc\presentation\responses\HttpResponse;
use vsc\application\sitemaps\ControllerMap;
use vsc\presentation\responses\HttpResponseA;

class RESTController extends JsonController {
	/**
	 * @param HttpRequestA $oRequest
	 * @param RESTProcessorA $oProcessor
	 * @returns HttpResponseA
	 * @throws \vsc\presentation\responses\ExceptionResponse
	 * @throws \vsc\presentation\responses\ExceptionResponseError
	 * @throws \vsc\presentation\views\ExceptionView
	 * @throws ExceptionResponseError
	 */
	public function getResponse (HttpRequestA $oRequest, $oProcessor = null) {
		$oResponse = new HttpResponse(); // this needs changing for REST stuff
		$oModel = null;
		/* @var ControllerMap $oMyMap */
		$oMyMap	= $this->getMap();

		try {
			if ( !$oRequest->isGet() ) {
				if (!RESTRequest::isValid($oRequest)) {
					throw new ExceptionResponseError ('Invalid request.', 415);
				}
				if ( RESTRequest::hasContentType() && !RESTRequest::validContentType($oRequest->getContentType()) ) {
					throw new ExceptionResponseError ('Invalid request content type.', 415);
				}
			}

			/* @var RESTProcessorA $oProcessor */
			if (RESTProcessorA::isValid($oProcessor) && !$oProcessor->validRequestMethod($oRequest->getHttpMethod())) {
				throw new ExceptionResponseError ('Invalid request method.', 405);
			}
			$oMap = $oProcessor->getMap();
			if ( $oMap->requiresAuthentication() ) {
				try {
					if ( $oProcessor instanceof AuthenticatedProcessorI ) {
						/* @var AuthenticatedProcessorI $oProcessor */
						if ( !$oRequest->hasAuthenticationData() ) {
							throw new ExceptionAuthenticationNeeded ('This resource needs authentication');
						}
						if ( $oRequest->getAuthentication()->getType() & $oMap->getAuthenticationType() == $oRequest->getAuthentication()->getType()) {
							throw new ExceptionAuthenticationNeeded ('Invalid authorization scheme. Supported schemes: ' . implode(', ', $oMap->getValidAuthenticationSchemas()));
						}
						if ( !$oProcessor->handleAuthentication ($oRequest->getAuthentication()) ) {
							throw new ExceptionAuthenticationNeeded ('Invalid authentication data', 'testrealm');
						}
					} else {
						throw new ExceptionAuthenticationNeeded ('This resource requires authentication but doesn\'t support any authorization scheme');
					}
				} catch (ExceptionAuthenticationNeeded $e) {
					$oErrorProcessor = new ErrorProcessor($e);

					$oResponse = parent::getResponse($oRequest, $oErrorProcessor);
					$oResponse->addHeader('WWW-Authorization', $e->getChallenge());
					return $oResponse;
				}
			}
		} catch (\Exception $e) {
			// we had error in the controller
			// @todo make more error processors
			if ( $e instanceof ExceptionResponseError ) {
				$oResponse->setStatus($e->getErrorCode());
			}
			$oProcessor = new ErrorProcessor($e);

			$oMyMap->setMainTemplatePath(VSC_RES_PATH . 'templates');
			$oMyMap->setMainTemplate('main.php');

			$oModel = $oProcessor->handleRequest($oRequest);
		}
		$oResponse = parent::getResponse($oRequest, $oProcessor);

		return $oResponse;
	}
}
