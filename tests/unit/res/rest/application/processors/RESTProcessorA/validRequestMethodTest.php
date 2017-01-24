<?php
namespace res\rest\application\processors\RESTProcessorA;
use vsc\rest\application\processors\RESTProcessorA;
use vsc\presentation\requests\HttpRequestTypes;
use vsc\presentation\requests\HttpRequestA;
use vsc\infrastructure\Base;
use vsc\presentation\requests\RawHttpRequest;


/**
 * Class validRequestMethodTest
 * @package res\rest\application\processors\RESTProcessorA
 * @covers \vsc\rest\application\processors\RESTProcessorA::validRequestMethod()
 */
class validRequestMethodTest extends \BaseUnitTest {

	public function testBasicValidRequestMethod() {
		$o = new RESTProcessorA_underTest_validRequestMethod();
		$RequestTypes = [
			HttpRequestTypes::GET,
			HttpRequestTypes::POST,
			HttpRequestTypes::PUT,
			HttpRequestTypes::DELETE,
			HttpRequestTypes::HEAD,
			HttpRequestTypes::OPTIONS
		];

		$o->validRequestMethods = $RequestTypes;
		foreach ($RequestTypes as $method) {
			$this->assertTrue($o->validRequestMethod($method));
		}
	}

	public function testBasicInValidRequestMethod() {
		$o = new RESTProcessorA_underTest_validRequestMethod();
		$RequestTypes = [
			HttpRequestTypes::GET,
			HttpRequestTypes::POST,
			HttpRequestTypes::PUT,
			HttpRequestTypes::DELETE,
			HttpRequestTypes::HEAD,
			HttpRequestTypes::OPTIONS
		];

		foreach ($RequestTypes as $method) {
			$this->assertFalse($o->validRequestMethod($method));
		}
	}
}

class RESTProcessorA_underTest_validRequestMethod extends RESTProcessorA {
	public $validRequestMethods = [];

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
