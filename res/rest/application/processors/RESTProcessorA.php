<?php
/**
 * A processor for RESTful calls
 *
 * @package application/processors
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2013.10.04
 */
namespace vsc\application\processors;

use vsc\domain\models\ArrayModel;
use vsc\infrastructure\vsc;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestTypes;
use vsc\presentation\requests\RawHttpRequest;
use vsc\presentation\responses\ExceptionResponseError;

abstract class RESTProcessorA extends ProcessorA {
	protected $validRequestMethods = array ( );

	public function getValidRequestMethods () {
		return $this->validRequestMethods;
	}

	public function validRequestMethod ($sRequestMethod) {
		return (in_array($sRequestMethod, $this->getValidRequestMethods()));
	}

	abstract public function handleGet (HttpRequestA $oRequest);
	abstract public function handleHead (HttpRequestA $oRequest);
	abstract public function handlePost (HttpRequestA $oRequest);
	abstract public function handlePut (RawHttpRequest $oRequest);
	abstract public function handleDelete (RawHttpRequest $oRequest);

	public function handleOptions (HttpRequestA $oRequest) {
		$oMirror = new \ReflectionClass($this);

		$aMethods = $oMirror->getMethods(\ReflectionProperty::IS_PUBLIC);
		$aReflectionDocComments = array();
		foreach ($aMethods as $key => $oReflectionMethod) {
			/* @var $oReflectionMethod \ReflectionMethod */
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

		return new ArrayModel($aReflectionDocComments);
	}

	public function handleRequest (HttpRequestA $oRequest) {
		if ( !$oRequest->isGet() && !RawHttpRequest::isValid($oRequest)) {
			$oRequest = new RawHttpRequest();
			vsc::getEnv()->setHttpRequest($oRequest);
		}

		switch ($oRequest->getHttpMethod()) {
			case HttpRequestTypes::GET:
				return $this->handleGet ($oRequest);
				break;
			case HttpRequestTypes::HEAD:
				return $this->handleHead ($oRequest);
				break;
			case HttpRequestTypes::POST:
				return $this->handlePost ($oRequest);
				break;
			case HttpRequestTypes::PUT:
				return $this->handlePut ($oRequest);
				break;
			case HttpRequestTypes::DELETE:
				return $this->handleDelete ($oRequest);
				break;
			case HttpRequestTypes::OPTIONS:
				// mainly used for introspection
				return $this->handleOptions ($oRequest);
				break;
			default:
				throw new ExceptionResponseError ('Method ['.$oRequest->getHttpMethod().'] is unavailable.', 405);
		}
	}
}
