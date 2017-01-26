<?php
namespace tests\rest\application\processors\RESTProcessorA;
use vsc\infrastructure\Base;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestTypes;
use vsc\presentation\requests\RawHttpRequest;
use vsc\rest\application\processors\RESTProcessorA;
/**
 * @covers \vsc\rest\application\processors\RESTProcessorA::getValidRequestMethods()
 */
class getValidRequestMethods extends \BaseUnitTest
{
	public function testBasicGetValidRequestMethods()
	{
		$s = new RESTProcessorA_underTest_getValidRequestMethods();
		$ValidOptions = $s->getValidRequestMethods();

		$Values = array(
			HttpRequestTypes::GET,
			HttpRequestTypes::POST,
			HttpRequestTypes::PUT,
			HttpRequestTypes::DELETE,
			HttpRequestTypes::HEAD,
			HttpRequestTypes::OPTIONS
		);
		$this->assertArraySubset($Values, $ValidOptions);
	}
}

class RESTProcessorA_underTest_getValidRequestMethods extends RESTProcessorA {
	public function getValidRequestMethods() {
		return array(
			HttpRequestTypes::GET,
			HttpRequestTypes::POST,
			HttpRequestTypes::PUT,
			HttpRequestTypes::DELETE,
			HttpRequestTypes::HEAD,
			HttpRequestTypes::OPTIONS
		);
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
		return new Base();
	}

	public function handleHead(HttpRequestA $oRequest)
	{
		return $this->handleGet($oRequest);
	}

	public function handlePost(HttpRequestA $oRequest)
	{
		return $this->handleGet($oRequest);
	}

	public function handlePut(RawHttpRequest $oRequest)
	{
		return $this->handleGet($oRequest);
	}

	public function handleDelete(RawHttpRequest $oRequest)
	{
		return $this->handleGet($oRequest);
	}
}
