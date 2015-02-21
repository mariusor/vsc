<?php
namespace vsc\application\controllers;

use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\views\ExceptionView;
use vsc\presentation\views\ViewA;

class ContentTypeController extends FrontControllerA {


	public function isValidContentType($sContentType) {}

	public function getAvailableContentTypes() {}

	public function getController() {}

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
	}

	/**
	 * @param HttpRequestA $oRequest
	 * @param null $oProcessor
	 * @return \vsc\presentation\responses\HttpResponse|\vsc\presentation\responses\HttpResponseA
	 */
	public function getErrorResponse(HttpRequestA $oRequest, $oProcessor = null) {
	}

	/**
	 * @returns ViewA
	 * @throws ExceptionView
	 */
	public function getView() {
	}
}
