<?php
/**
 * @package vsc_presentation
 * @subpackage processors
 * @author marius orcsik <marius@habarnam.ro>
 * @date 12.08.25
 */
namespace vsc\application\processors;

// \vsc\import ('domain');
// \vsc\import ('access');
use vsc\domain\models\vscJsonRPCRequest;
use vsc\domain\models\vscJsonRPCResponse;
use vsc\presentation\requests\vscHttpRequestA;
use vsc\presentation\responses\vscExceptionResponseError;
use vsc\presentation\responses\vscHttpResponse;
use vsc\vscException;

abstract class vscRPCProcessor extends vscProcessorA {
	private $oRequest;
	private $oResponse;
	protected $oInterface;

	public function init () {
		$this->oRequest		= new vscJsonRPCRequest();
		$this->oResponse	= new vscJsonRPCResponse();

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

	abstract public function getRPCInterface ($sNameSpace = null);

	public function hasRPCMethod ($oInterface, $sMethod) {
		if (empty ($sMethod) || empty ($oInterface)) return false;

		$oReflectedInterface = new \ReflectionObject($oInterface);
		if ($oReflectedInterface->hasMethod($sMethod)) {
			/* @var $oReflectedMethod \ReflectionMethod */
			$oReflectedMethod = $oReflectedInterface->getMethod($sMethod);
			return $oReflectedMethod->isPublic();
		}
		return false;
	}

	public function callRPCMethod () {
		$sRawMethod = $this->oRequest->method;

		@list($sNameSpace, $sMethod) = explode ('.', $sRawMethod);
		if (is_null($sMethod)) {
			$sMethod = $sNameSpace;
			$sNameSpace = 'wp';
		}

		$oInterface = $this->getRPCInterface($sNameSpace);
		if (!$this->hasRPCMethod($oInterface, $sMethod)) {
			$this->oResponse->error = 'Invalid RPC request: method [' . var_export($sMethod, true) .'] does not exist';
		} else {
			if (is_null ($this->oRequest->params) || !is_array($this->oRequest->params)) {
				throw new vscExceptionResponseError('Invalid RPC request: missing parameters');
			}

			$oReflectedInterface = new \ReflectionObject($oInterface);
			if ($oReflectedInterface->hasMethod($sMethod)) {
				/* @var $oReflectedMethod \ReflectionMethod */
				$oReflectedMethod = $oReflectedInterface->getMethod($sMethod);
				if ( $oReflectedMethod->isPublic() ) {
					return $oReflectedMethod->invokeArgs($oInterface, $this->oRequest->params);
				}
			}
		}
		return null;
	}

	public function handleRequest(vscHttpRequestA $oHttpRequest) {
		try {
			$this->oResponse->result = $this->callRPCMethod ();
		} catch (vscExceptionResponseError $e) {

			$oError = new vscHttpResponse();
			$oError->setStatus($e->getErrorCode());
			$this->getMap()->setResponse($oError);
			$this->oResponse->error = $e->getMessage();

		} catch (vscException $e) {

			$oError = new vscHttpResponse();
			$oError->setStatus(500);
			$this->getMap()->setResponse($oError);
			$this->oResponse->error = $e->getMessage();

		}
		return $this->oResponse;
	}
}