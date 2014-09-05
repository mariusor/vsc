<?php
namespace fixtures\application\processors;

use vsc\domain\models\RESTModel;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestTypes;
use vsc\presentation\requests\RawHttpRequest;
use vsc\rest\application\processors\RESTProcessorA;

class RESTProcessorFixture extends RESTProcessorA {
	protected $validRequestMethods = array ();

	protected $validContentTypes = array ();

	public function setContentTypes ($aContentTypes) {
		$this->validContentTypes = $aContentTypes;
	}

	public function setRequestMethods ($aRequestMethods) {
		$this->validRequestMethods = $aRequestMethods;
	}

	/**
	 * @param RawHttpRequest $oHttpRequest
	 * @return RESTModel
	 */
	public function getModel(RawHttpRequest $oHttpRequest) {
		return new RESTModel();
	}

	/**
	 * @return void
	 */
	public function init()
	{
		// TODO: Implement init() method.
	}

	public function handleGet(HttpRequestA $oRequest)
	{
		// TODO: Implement handleGet() method.
	}

	public function handleHead(HttpRequestA $oRequest)
	{
		// TODO: Implement handleHead() method.
	}

	public function handlePost(HttpRequestA $oRequest)
	{
		// TODO: Implement handlePost() method.
	}

	public function handlePut(RawHttpRequest $oRequest)
	{
		// TODO: Implement handlePut() method.
	}

	public function handleDelete(RawHttpRequest $oRequest)
	{
		// TODO: Implement handleDelete() method.
	}
}
