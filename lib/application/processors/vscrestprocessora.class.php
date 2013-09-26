<?php
/**
 * A processor for RESTful calls
 *
 * @package application/processors
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2012-08-25
 */
abstract class vscRESTProcessorA extends vscProcessorA {

	public function validRequestMethod ($sRequestMethod) {
		return ($sRequestMethod == vscHttpRequestTypes::OPTIONS);
	}

	abstract public function handleGet (vscHttpRequestA $oRequest);
	abstract public function handleHead (vscHttpRequestA $oRequest);
	abstract public function handlePost (vscHttpRequestA $oRequest);
	abstract public function handlePut (vscRawHttpRequest $oRequest);
	abstract public function handleDelete (vscRawHttpRequest $oRequest);

	public function handleOptions (vscHttpRequestA $oRequest) {
		$oMirror = new ReflectionClass($this);

		$aMethods = $oMirror->getMethods(ReflectionProperty::IS_PUBLIC);
		$aReflectionDocComments = array();
		foreach ($aMethods as $key => $oReflectionMethod) {
			/* @var $oReflectionMethod ReflectionMethod */
			if ( stristr($oReflectionMethod->getName(), 'handle') !== false) {
				$sDocumentation = $oReflectionMethod->getDocComment();
				if (!empty($sDocumentation)) {
					// this needs some phpdoc parser
					$aReflectionDocComments[$oReflectionMethod->getName()] = $sDocumentation;
				}
			}
		}

		$this->getMap()->setTemplatePath(VSC_RES_PATH . 'templates');
		$this->getMap()->setTemplate('introspection.tpl.php');

		return new vscArrayModel ($aReflectionDocComments);
	}

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
			case vscHttpRequestTypes::OPTIONS:
				// mainly used for introspection
				return $this->handleOptions ($oRequest);
				break;
			default:
				throw new vscExceptionResponseError ('Method ['.$oRequest->getHttpMethod().'] is unavailable.', 405);
		}
	}
}
