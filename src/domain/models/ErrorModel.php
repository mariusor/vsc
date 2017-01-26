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

class ErrorModel extends ModelA {
	private $exception;

	public $message;
	public $error_code;

	public function __construct(\Exception $e = null) {
		if ($e instanceof \Exception) {
			$this->setException($e);
		}
		parent::__construct();
	}

	public function getMessage() {
		return $this->getException()->getMessage();
	}

	public function setException(\Exception $e) {
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
	public function getException() {
		return $this->exception;
	}

	public function getHttpStatus() {
		if (is_numeric($this->error_code)) {
			return $this->error_code;
		} else {
			return HttpResponseType::INTERNAL_ERROR;
		}
	}
}
