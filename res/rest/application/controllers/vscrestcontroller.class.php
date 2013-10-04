<?php
/**
 * Created by JetBrains PhpStorm.
 * User: habarnam
 * Date: 9/25/13
 * Time: 5:42 PM
 * To change this template use File | Settings | File Templates.
 */
class vscRESTController extends vscJsonController {
	public function getResponse (vscHttpRequestA $oRequest, $oProcessor = null) {
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

		$oResponse = parent::getResponse($oRequest, $oProcessor);

		return $oResponse;
	}
}
