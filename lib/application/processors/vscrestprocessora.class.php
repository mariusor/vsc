<?php
/**
 * A processor for RESTful calls
 *
 * @package application/processors
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2012-08-25
 */
abstract class vscRestProcessorA extends vscProcessorA {

	abstract public function handleGet (vscHttpRequestA $oRequest);
	abstract public function handleHead (vscHttpRequestA $oRequest);
	abstract public function handlePost (vscHttpRequestA $oRequest);
	abstract public function handlePut (vscRawHttpRequest $oRequest);
	abstract public function handleDelete (vscRawHttpRequest $oRequest);

	public function handleRequest (vscHttpRequestA $oRequest) {
		if ( !$oRequest->isGet() && !vscRawHttpRequest::isValid($oRequest)) {
			$oRequest = new vscRawHttpRequest();
				vsc::getEnv()->setHttpRequest($oRequest);
		}

		switch ($oRequest->getHttpMethod()) {
			case vscHttpRequestTypes::GET:
				return $this->handleGet ($oRequest);
				break;
			case vscHttpRequestTypes::HEAD:
				return $this->handleHead ($oRequest);
				break;
			case vscHttpRequestTypes::POST:
				return $this->handlePost ($oRequest);
				break;
			case vscHttpRequestTypes::PUT:
				return $this->handlePut ($oRequest);
				break;
			case vscHttpRequestTypes::DELETE:
				return $this->handleDelete ($oRequest);
				break;
		}
	}
}