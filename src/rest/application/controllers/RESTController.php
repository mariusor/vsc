<?php
/**
 * A controller for RESTful calls
 *
 * @package application/controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2013.10.04
 */
namespace vsc\rest\application\controllers;

use vsc\application\controllers\ExceptionController;
use vsc\application\controllers\JsonController;
use vsc\application\processors\AuthenticatedProcessorInterface;
use vsc\application\processors\ProcessorA;
use vsc\presentation\requests\ContentType;
use vsc\presentation\responses\HttpResponseType;
use vsc\rest\application\processors\RESTProcessorA;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\responses\ExceptionAuthenticationNeeded;
use vsc\presentation\responses\ExceptionResponseError;
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
	public function getResponse(HttpRequestA $oRequest, $oProcessor = null) {
		$oModel = null;

		try {
			if (!$oRequest->isGet()) {
				if ($oRequest->hasContentType() && !ContentType::isValidContentType($oRequest->getContentType())) {
					throw new ExceptionResponseError('Invalid request content type', HttpResponseType::UNSUPPORTED_MEDIA_TYPE);
				}
			}
			if (!ProcessorA::isValid($oProcessor)) {
				throw new ExceptionController('Invalid request processor');
			}
			/* @var RESTProcessorA $oProcessor */
			if (RESTProcessorA::isValid($oProcessor) && !$oProcessor->validRequestMethod($oRequest->getHttpMethod())) {
				throw new ExceptionResponseError('Invalid request method', HttpResponseType::METHOD_NOT_ALLOWED);
			}
			$oMap = $oProcessor->getMap();
			if ($oMap->requiresAuthentication()) {
				try {
					if ($oProcessor instanceof AuthenticatedProcessorInterface) {
						/* @var AuthenticatedProcessorInterface $oProcessor */
						if (!$oRequest->hasAuthenticationData()) {
							throw new ExceptionAuthenticationNeeded('This resource needs authentication');
						}
						// here we check that the request contains the same authentication type as the map
						if (($oRequest->getAuthentication()->getType() & $oMap->getAuthenticationType()) !== $oMap->getAuthenticationType()) {
							throw new ExceptionAuthenticationNeeded('Invalid authorization scheme. Supported schemes: ' . implode(', ', $oMap->getValidAuthenticationSchemas()));
						}
						if (!$oProcessor->handleAuthentication($oRequest->getAuthentication())) {
							throw new ExceptionAuthenticationNeeded('Invalid authentication data', 'testrealm');
						}
					} else {
						throw new ExceptionAuthenticationNeeded('This resource requires authentication but doesn\'t support any authorization scheme');
					}
				} catch (ExceptionAuthenticationNeeded $e) {
					return $this->getErrorResponse($e, $oRequest);
				}
			}
		} catch (\Exception $e) {
			return $this->getErrorResponse($e, $oRequest);
		}
		return parent::getResponse($oRequest, $oProcessor);
	}

	/**
	 * Returns a view based on the
	 * @fixme
	 * @return \vsc\presentation\views\JsonView
	 */
	public function getDefaultView() {
		return parent::getDefaultView();
	}
}
