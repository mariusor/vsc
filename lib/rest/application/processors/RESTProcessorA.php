<?php
/**
 * A processor for RESTful calls
 *
 * @package application/processors
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2013.10.04
 */
namespace vsc\rest\application\processors;

use vsc\application\processors\ProcessorA;
use vsc\infrastructure\vsc;
use vsc\presentation\requests\ContentType;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestTypes;
use vsc\presentation\requests\RawHttpRequest;
use vsc\presentation\responses\ExceptionResponseError;
use vsc\presentation\responses\HttpResponseType;

abstract class RESTProcessorA extends ProcessorA {
	protected $validRequestMethods = array ( );

	public function getValidRequestMethods () {
		return $this->validRequestMethods;
	}

	protected $validContentTypes = array ('*/*');

	public function getValidContentTypes () {
		return $this->validContentTypes;
	}

	public function validRequestMethod ($sRequestMethod) {
		return (in_array($sRequestMethod, $this->getValidRequestMethods()));
	}

	public function validContentType ($sContentType) {
		return ContentType::isAccepted($sContentType, $this->getValidContentTypes());
	}

	abstract public function handleGet (HttpRequestA $oRequest);
	abstract public function handleHead (HttpRequestA $oRequest);
	abstract public function handlePost (HttpRequestA $oRequest);
	abstract public function handlePut (RawHttpRequest $oRequest);
	abstract public function handleDelete (RawHttpRequest $oRequest);

	/**
	 * @param HttpRequestA $oRequest
	 * @return \vsc\domain\models\ModelA
	 * @throws \vsc\presentation\responses\ExceptionResponseError
	 */
	public function handleRequest (HttpRequestA $oRequest) {
		if ( !$oRequest->isGet() && !RawHttpRequest::isValid($oRequest)) {
			$oRequest = new RawHttpRequest();
			vsc::getEnv()->setHttpRequest($oRequest);
		}

		switch ($oRequest->getHttpMethod()) {
			case HttpRequestTypes::GET:
				$oModel = $this->handleGet ($oRequest);
				break;
			case HttpRequestTypes::HEAD:
				$oModel = $this->handleHead ($oRequest);
				break;
			case HttpRequestTypes::POST:
				$oModel = $this->handlePost ($oRequest);
				break;
			case HttpRequestTypes::PUT:
				$oModel = $this->handlePut ($oRequest);
				break;
			case HttpRequestTypes::DELETE:
				$oModel = $this->handleDelete ($oRequest);
				break;
			default:
				throw new ExceptionResponseError ('Method ['.$oRequest->getHttpMethod().'] is unavailable.', HttpResponseType::METHOD_NOT_ALLOWED);
		}
		return $oModel;
	}
}
