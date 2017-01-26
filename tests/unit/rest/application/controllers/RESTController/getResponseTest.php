<?php
namespace res\rest\application\controllers\RESTController;

use mocks\application\processors\ProcessorFixture;
use mocks\domain\models\ModelFixture;
use mocks\presentation\requests\PopulatedRESTRequest;
use vsc\application\controllers\ExceptionController;
use vsc\application\processors\AuthenticatedProcessorInterface;
use vsc\application\sitemaps\ClassMap;
use vsc\infrastructure\vsc;
use vsc\presentation\requests\HttpAuthenticationA;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestTypes;
use vsc\presentation\requests\RawHttpRequest;
use vsc\presentation\responses\HttpResponse;
use vsc\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseType;
use vsc\rest\application\controllers\RESTController;
use vsc\rest\application\processors\RESTProcessorA;
use vsc\rest\presentation\requests\RESTRequest;

/**
 * @covers \vsc\rest\application\controllers\RESTController::getResponse()
 */
class getResponseTest extends \BaseUnitTest {

	public function tearDown () {
		foreach ($_SERVER as $key => $value) {
			unset($_SERVER[$key]);
		}

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
		$_SERVER['PHP_AUTH_USER'] = 'alladin';
		$_SERVER['PHP_AUTH_PW'] = '123#';
		$_SERVER['CONTENT_TYPE'] = 'application/json';
		$_SERVER['REQUEST_METHOD'] = 'GET';

		$oRequest = new RESTRequest();
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

	public function testWithAuthenticatedProcessorAndMapRequiringAuthentication() {
		$o = new RESTController();

		$_SERVER['PHP_AUTH_USER'] = 'alladin';
		$_SERVER['PHP_AUTH_PW'] = '123#';
		$_SERVER['CONTENT_TYPE'] = 'application/json';
		$_SERVER['REQUEST_METHOD'] = 'GET';

		$m = new ClassMap(ProcessorFixture::class, '.*');
		$m->setAuthenticationType(HttpAuthenticationA::BASIC);

		$p = new RESTProcessorA_underTest_getResponse_withAuthentication();
		$p->setMap($m);

		$r = $o->getResponse(new RESTRequest(), $p);
		$this->assertInstanceOf(HttpResponse::class, $r);
		$this->assertEquals(HttpResponseType::NOT_AUTHORIZED, $r->getStatus());
		$err = [
			'message' => 'Invalid authentication data',
			'error_code' => HttpResponseType::NOT_AUTHORIZED
		];
		$this->assertJsonStringEqualsJsonString(json_encode($err), $r->getOutput());
	}

	public function testWithAuthenticatedProcessorAndMapRequiringDifferentAuthenticationType() {
		$o = new RESTController();

		$_SERVER['PHP_AUTH_USER'] = 'alladin';
		$_SERVER['PHP_AUTH_PW'] = '123#';
		$_SERVER['CONTENT_TYPE'] = 'application/json';
		$_SERVER['REQUEST_METHOD'] = 'GET';

		$m = new ClassMap(ProcessorFixture::class, '.*');
		$m->setAuthenticationType(HttpAuthenticationA::DIGEST);

		$p = new RESTProcessorA_underTest_getResponse_withAuthentication();
		$p->setMap($m);

		$r = $o->getResponse(new RESTRequest(), $p);
		$this->assertInstanceOf(HttpResponse::class, $r);
		$this->assertEquals(HttpResponseType::NOT_AUTHORIZED, $r->getStatus());
		$err = [
			'message' => 'Invalid authorization scheme. Supported schemes: Digest',
			'error_code' => HttpResponseType::NOT_AUTHORIZED
		];
		$this->assertJsonStringEqualsJsonString(json_encode($err), $r->getOutput());
	}

	public function testWithNoProcessor() {
		$o = new RESTController();

		$_SERVER['PHP_AUTH_USER'] = 'alladin';
		$_SERVER['PHP_AUTH_PW'] = '123#';
		$_SERVER['CONTENT_TYPE'] = 'application/json';
		$_SERVER['REQUEST_METHOD'] = 'GET';

		$r = $o->getResponse(new RESTRequest());

		$this->assertInstanceOf(HttpResponse::class, $r);
		$this->assertEquals(HttpResponseType::INTERNAL_ERROR, $r->getStatus());
		$err = ['message' => 'Invalid request processor'];
		$this->assertJsonStringEqualsJsonString(json_encode($err), $r->getOutput());
	}

	public function testWithProcessorThatReturnsFalseForAuthentication() {
		$o = new RESTController();

		$_SERVER['PHP_AUTH_USER'] = 'alladin';
		$_SERVER['PHP_AUTH_PW'] = '123#';
		$_SERVER['CONTENT_TYPE'] = 'application/json';
		$_SERVER['REQUEST_METHOD'] = 'GET';

		$m = new ClassMap(ProcessorFixture::class, '.*');
		$m->setAuthenticationType(HttpAuthenticationA::BASIC);

		$p = new RESTProcessorA_underTest_getResponse_withAuthentication();
		$p->setMap($m);

		$r = $o->getResponse(new RESTRequest(), $p);
		$this->assertInstanceOf(HttpResponse::class, $r);
		$this->assertEquals(HttpResponseType::NOT_AUTHORIZED, $r->getStatus());
		$err = [
			'message' => 'Invalid authentication data',
			'error_code' => HttpResponseType::NOT_AUTHORIZED
		];
		$this->assertJsonStringEqualsJsonString(json_encode($err), $r->getOutput());
	}

	public function testWithNonAuthenticatedProcessorAndMapRequiringAuthentication() {
		$o = new RESTController();

		$_SERVER['PHP_AUTH_USER'] = 'alladin';
		$_SERVER['PHP_AUTH_PW'] = '123#';
		$_SERVER['CONTENT_TYPE'] = 'application/json';
		$_SERVER['REQUEST_METHOD'] = 'GET';

		$m = new ClassMap(ProcessorFixture::class, '.*');
		$m->setAuthenticationType(HttpAuthenticationA::BASIC);

		$p = new RESTProcessorA_underTest_getResponse ();
		$p->validRequestMethods = [HttpRequestTypes::GET];
		$p->setMap($m);

		$r = $o->getResponse(new RESTRequest(), $p);
		$this->assertInstanceOf(HttpResponse::class, $r);
		$this->assertEquals(HttpResponseType::NOT_AUTHORIZED, $r->getStatus());
		$err = [
			'message' => 'This resource requires authentication but doesn\'t support any authorization scheme',
			'error_code' => HttpResponseType::NOT_AUTHORIZED
		];
		$this->assertJsonStringEqualsJsonString(json_encode($err), $r->getOutput());
	}
}

class RESTProcessorA_underTest_getResponse extends RESTProcessorA {
	public $validRequestMethods = [];

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

class RESTProcessorA_underTest_getResponse_withAuthentication extends RESTProcessorA_underTest_getResponse implements AuthenticatedProcessorInterface {
	public $validRequestMethods = [HttpRequestTypes::GET];
	public function handleAuthentication(HttpAuthenticationA $oHttpAuthentication)
	{
		return false;
	}
}
