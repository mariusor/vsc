<?php
/**
 * @package vsc_domain
 * @subpackage models
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2011.11.20
 */
namespace vsc\domain\models;

// \vsc\import ('domain/models');
// \vsc\import ('presentation/responses');
use vsc\presentation\responses\vscExceptionResponseError;
use vsc\presentation\responses\vscHttpResponseType;

class vscErrorModel extends vscEmptyModel {
	private $exception;

	public $message;
	public $error_code;
	
	public function __construct(\Exception $e) {
		$this->setException($e);
		parent::__construct();
	}

	public function getPageTitle () {
		$e = $this->getException();
		if ($e instanceof \Exception) {
			return vscHttpResponseType::getStatus($e->getCode());
		}
	}

	public function getPageContent () {
		return $this->getException()->getMessage();
	}

	public function getMessage () {
		return $this->getException()->getMessage();
	}

	public function setException (\Exception $e) {
		$this->exception = $e;
		$this->message = $e->getMessage();
		
		if (vscExceptionResponseError::isValid($e)) {
			/** @var vscExceptionResponseError $e */
			$this->error_code = $e->getErrorCode();
		}
	}

	/**
	 * @return vscExceptionResponseError
	 */
	public function getException () {
		return $this->exception;
	}
}
