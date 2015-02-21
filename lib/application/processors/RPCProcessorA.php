<?php
/**
 * @package presentation
 * @subpackage processors
 * @author marius orcsik <marius@habarnam.ro>
 * @date 12.08.25
 */
namespace vsc\application\processors;

use vsc\domain\models\JsonRPCRequest;
use vsc\domain\models\JsonRPCResponse;
use vsc\infrastructure\vsc;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\responses\ExceptionResponseError;
use vsc\Exception;

abstract class RPCProcessorA extends ProcessorA {
	private $oRequest;
	private $oResponse;
	protected $oInterface;

	public function __construct() {
		$this->oRequest		= new JsonRPCRequest(vsc::getEnv()->getHttpRequest());
		$this->oResponse	= new JsonRPCResponse();
	}

	public function init() {
		$this->oResponse->id = $this->oRequest->id;
// 		if (!$oRequest->accepts('application/json')) {
// 			// user-agent doesn't understand json
// 		}
	}

	public function getRequest() {
		return $this->oRequest;
	}

	public function getResponse() {
		return $this->oResponse;
	}

	abstract public function getRPCInterface($sNameSpace = null);

	public function hasRPCMethod($oInterface, $sMethod) {
		if (empty ($sMethod) || empty ($oInterface)) {
			return false;
		}

		$oReflectedInterface = new \ReflectionObject($oInterface);
		if ($oReflectedInterface->hasMethod($sMethod)) {
			/* @var $oReflectedMethod \ReflectionMethod */
			$oReflectedMethod = $oReflectedInterface->getMethod($sMethod);
			return $oReflectedMethod->isPublic();
		}
		return false;
	}

	public function callRPCMethod() {
		$sRawMethod = $this->oRequest->method;

		@list($sNameSpace, $sMethod) = explode('.', $sRawMethod);
		if (is_null($sMethod)) {
			$sMethod = $sNameSpace;
			$sNameSpace = 'wp';
		}

		$oInterface = $this->getRPCInterface($sNameSpace);
		if (!$this->hasRPCMethod($oInterface, $sMethod)) {
			$this->oResponse->error = 'Invalid RPC request: method ['.var_export($sMethod, true).'] does not exist';
		} else {
			if (is_null($this->oRequest->params) || !is_array($this->oRequest->params)) {
				throw new ExceptionResponseError('Invalid RPC request: missing parameters');
			}

			$oReflectedInterface = new \ReflectionObject($oInterface);
			if ($oReflectedInterface->hasMethod($sMethod)) {
				/* @var $oReflectedMethod \ReflectionMethod */
				$oReflectedMethod = $oReflectedInterface->getMethod($sMethod);
				if ($oReflectedMethod->isPublic()) {
					return $oReflectedMethod->invokeArgs($oInterface, $this->oRequest->params);
				}
			}
		}
		return null;
	}

	public function handleRequest(HttpRequestA $oHttpRequest) {
		try {
			$this->oResponse->result = $this->callRPCMethod();
		} catch (ExceptionResponseError $e) {

			$oError = vsc::getEnv()->getHttpResponse();
			$oError->setStatus($e->getErrorCode());
			$this->getMap()->setResponse($oError);
			$this->oResponse->error = $e->getMessage();

		} catch (Exception $e) {
			$oError = vsc::getEnv()->getHttpResponse();
			$oError->setStatus(500);
			$this->getMap()->setResponse($oError);
			$this->oResponse->error = $e->getMessage();

		}
		return $this->oResponse;
	}
}
