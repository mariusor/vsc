<?php
namespace res\rest\application\processors\RESTProcessorA;
use vsc\rest\application\processors\RESTProcessorA;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\RawHttpRequest;

/**
 * Class getValidContentTypesTest
 * @package res\rest\application\processors\RESTProcessorA
 * @covers \vsc\rest\application\processors\RESTProcessorA::getValidContentTypes()
 */
class getValidContentTypesTest extends \BaseUnitTest {
	public function testBasic() {
		$o = new RESTProcessorA_underTest_getValidContentTypes();
		$this->assertSame($o->validContentTypes, $o->getValidContentTypes());
	}
}

class RESTProcessorA_underTest_getValidContentTypes extends RESTProcessorA {
	public $validContentTypes = ['*/*'];
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
