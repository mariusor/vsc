<?php
/**
 * @package domain
 * @subpackage models
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2011.11.20
 */
namespace vsc\domain\models;

use vsc\presentation\responses\ExceptionResponseError;
use vsc\presentation\responses\HttpResponseType;

class ErrorModel extends EmptyModel {
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
			return HttpResponseType::getStatus($e->getCode());
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

		if (ExceptionResponseError::isValid($e)) {
			/** @var ExceptionResponseError $e */
			$this->error_code = $e->getErrorCode();
		}
	}

	/**
	 * @returns ExceptionResponseError
	 */
	public function getException () {
		return $this->exception;
	}
}
