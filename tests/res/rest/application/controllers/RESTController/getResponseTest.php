<?php
namespace res\rest\application\controllers\RESTController;

use fixtures\domain\models\ModelFixture;
use fixtures\presentation\requests\PopulatedRESTRequest;
use vsc\application\controllers\ExceptionController;
use vsc\application\processors\EmptyProcessor;
use vsc\infrastructure\vsc;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestTypes;
use vsc\presentation\requests\RawHttpRequest;
use vsc\presentation\responses\HttpResponse;
use vsc\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseType;
use vsc\rest\application\controllers\RESTController;
use vsc\rest\application\processors\RESTProcessorA;

/**
 * @covers \vsc\rest\application\controllers\RESTController::getResponse()
 */
class getResponseTest extends \PHPUnit_Framework_TestCase {

	public function tearDown () {
		vsc::setInstance(new vsc());
	}

	public function testBasicGetResponse () {
		$o = new RESTController();

		$oProcessor = new RESTProcessorA_underTest_getResponse();
		$r = $o->getResponse(vsc::getEnv()->getHttpRequest(), $oProcessor);

		$this->assertInstanceOf(HttpResponse::class, $r);
	}

	public function testGetResponseInternalError () {
		$o = new RESTController();

		$oRequest = new PopulatedRESTRequest();
		$oResponse = $o->getResponse ( $oRequest );

		$this->assertInstanceOf ( HttpResponse::class, $oResponse );
		$this->assertInstanceOf ( HttpResponseA::class, $oResponse );
		$this->assertEquals ( HttpResponseType::INTERNAL_ERROR, $oResponse->getStatus () );
		$this->assertNotEmpty ( $oResponse->getOutput () );
	}

	public function testGetResponseMethodNotAllowed () {
		$o = new RESTController();

		$oRequest = new PopulatedRESTRequest();
		$oProcessor = new RESTProcessorA_underTest_getResponse();
		$oResponse = $o->getResponse($oRequest, $oProcessor);

		$this->assertInstanceOf(HttpResponse::class, $oResponse);
		$this->assertInstanceOf(HttpResponseA::class, $oResponse);
		$this->assertEquals(HttpResponseType::METHOD_NOT_ALLOWED, $oResponse->getStatus());
		$this->assertNotEmpty($oResponse->getOutput());
	}

	public function testGetResponseOK () {
		$o = new RESTController();

		$oRequest = new PopulatedRESTRequest();
		$oProcessor = new RESTProcessorA_underTest_getResponse();
		$oProcessor->setRequestMethods(array(HttpRequestTypes::GET));
		$oResponse = $o->getResponse($oRequest, $oProcessor);

		$this->assertInstanceOf(HttpResponse::class, $oResponse);
		$this->assertInstanceOf(HttpResponseA::class, $oResponse);
		$this->assertEquals(HttpResponseType::OK, $oResponse->getStatus());
		$this->assertNotEmpty($oResponse->getOutput());
	}

	public function testGetErrorResponse () {
		$o = new RESTController();

		$Exception = new ExceptionController();
		$oResponse = $o->getErrorResponse($Exception);

		$this->assertInstanceOf(HttpResponse::class, $oResponse);
		$this->assertInstanceOf(HttpResponseA::class, $oResponse);
		$this->assertEquals(HttpResponseType::INTERNAL_ERROR, $oResponse->getStatus());
		$this->assertNotEquals(HttpResponseType::OK, $oResponse->getStatus());

		$sOutput = $oResponse->getOutput();
		$this->assertNotEmpty($sOutput);

		$oOutput = json_decode($sOutput);
		$this->assertInstanceOf(\stdClass::class, $oOutput);
		$this->assertObjectHasAttribute('message', $oOutput);
		$this->assertEquals('', $oOutput->message);
	}
}

class RESTProcessorA_underTest_getResponse extends RESTProcessorA {
	public function setRequestMethods ($aContentTypes) {
		$this->validRequestMethods = $aContentTypes;
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
		return new ModelFixture();
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
