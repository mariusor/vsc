<?php
namespace res\rest\application\processors\RESTProcessorA;
use vsc\domain\models\ModelA;
use vsc\Exception;
use vsc\presentation\responses\ExceptionResponseError;
use vsc\presentation\responses\HttpResponseType;
use vsc\rest\application\processors\RESTProcessorA;
use vsc\presentation\requests\RawHttpRequest;
use vsc\presentation\requests\HttpRequestA;

/**
 * Class handleRequestTest
 * @package res\rest\application\processors\RESTProcessorA
 * @covers \vsc\rest\application\processors\RESTProcessorA::handleRequest()
 */
class handleRequestTest extends \PHPUnit_Framework_TestCase {

	public function testNoHttpMethod () {
		$o = new RESTProcessorA_underTest_handleRequest();
		try {
			$o->handleRequest(new RawHttpRequest());
		} catch (Exception $e) {
			$this->assertInstanceOf(ExceptionResponseError::class, $e);
			$this->assertEquals(HttpResponseType::METHOD_NOT_ALLOWED, $e->getCode());

			$msg = 'Method [] is unavailable.';
			$this->assertEquals($msg, $e->getMessage());
		}
	}

	public function testHandleGETRequest () {
		$_SERVER['REQUEST_METHOD'] = 'GET';
		$o = new RESTProcessorA_underTest_handleRequest();
		$model = $o->handleRequest(new RawHttpRequest());

		$this->assertInstanceOf(GETModel::class, $model);
	}

	public function testHandlePOSTRequest () {
		$_SERVER['REQUEST_METHOD'] = 'POST';
		$o = new RESTProcessorA_underTest_handleRequest();
		$model = $o->handleRequest(new RawHttpRequest());

		$this->assertInstanceOf(POSTModel::class, $model);
	}
	public function testHandlePUTRequest () {
		$_SERVER['REQUEST_METHOD'] = 'PUT';
		$o = new RESTProcessorA_underTest_handleRequest();
		$model = $o->handleRequest(new RawHttpRequest());

		$this->assertInstanceOf(PUTModel::class, $model);
	}

	public function testHandleDELETERequest () {
		$_SERVER['REQUEST_METHOD'] = 'DELETE';
		$o = new RESTProcessorA_underTest_handleRequest();
		$model = $o->handleRequest(new RawHttpRequest());

		$this->assertInstanceOf(DELETEModel::class, $model);
	}

	public function testHandleHEADRequest () {
		$_SERVER['REQUEST_METHOD'] = 'HEAD';
		$o = new RESTProcessorA_underTest_handleRequest();
		$model = $o->handleRequest(new RawHttpRequest());

		$this->assertInstanceOf(HEADModel::class, $model);
	}
}

class RESTProcessorA_underTest_handleRequest extends RESTProcessorA {

	/**
	 * @return void
	 */
	public function init()
	{
		// TODO: Implement init() method.
	}

	public function handleGet(HttpRequestA $oRequest)
	{
		return new GETModel();
	}

	public function handleHead(HttpRequestA $oRequest)
	{
		return new HEADModel();
	}

	public function handlePost(HttpRequestA $oRequest)
	{
		return new POSTModel();
	}

	public function handlePut(RawHttpRequest $oRequest)
	{
		return new PUTModel();
	}

	public function handleDelete(RawHttpRequest $oRequest)
	{
		return new DELETEModel();
	}
}

class GETModel extends ModelA {}
class POSTModel extends ModelA {}
class PUTModel extends ModelA {}
class DELETEModel extends ModelA {}
class HEADModel extends ModelA {}
