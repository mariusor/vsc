<?php
namespace vsc\application\controllers;

use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\views\ExceptionView;
use vsc\presentation\views\ViewA;

class ContentTypeController extends FrontControllerA {

	/**
	 * The current request content type
	 * @var string
	 */
	private $sContentType;

	public static function isValidContentType($sContentType) {}

	public function getAvailableContentTypes() {}

	public function getController() {}

	public function getContentType() {
		return $this->sContentType;
	}

	/**
	 * @returns ViewA
	 */
	public function getDefaultView() {
	}

	/**
	 * @param HttpRequestA $oRequest
	 * @param null $oProcessor
	 * @return \vsc\presentation\responses\HttpResponseA
	 */
	public function getResponse(HttpRequestA $oRequest, $oProcessor = null) {
		$this->sContentType = $oRequest->getContentType();

	}

	/**
	 * @param \Exception $e
	 * @param HttpRequestA $oRequest
	 * @return \vsc\presentation\responses\HttpResponseA
	 */
	public function getErrorResponse(\Exception $e, $oRequest = null) {
	}

	/**
	 * @returns ViewA
	 * @throws ExceptionView
	 */
	public function getView() {
		$sContentType = $this->getContentType();

	}
}
