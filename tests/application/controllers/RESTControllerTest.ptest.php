<?php
use fixtures\presentation\requests\PopulatedRESTRequest;
use \avangate\application\controllers\RESTController;
use \fixtures\application\controllers\FixtureRESTController;
use fixtures\application\processors\RESTProcessorFixture;
use \vsc\presentation\responses\HttpResponse;
use \vsc\presentation\responses\HttpResponseA;
use vsc\presentation\requests\HttpRequestTypes;
use \vsc\infrastructure\vsc;
use \vsc\application\sitemaps\ClassMap;
use \vsc\presentation\views\JsonView;
use \vsc\presentation\views\ViewA;
use \vsc\application\controllers\ExceptionController;
use \vsc\presentation\responses\HttpResponseType;

class RESTControllerTest extends PHPUnit_Framework_TestCase {
	/**
	 * @var  FixtureRESTController
	 */
	public $state;

	public function setUp() {
		$this->state = new FixtureRESTController();

		$oMap = new ClassMap(FixtureRESTController::class, '.*');
		$this->state->setMap($oMap);
	}
	public function tearDown() {}

	public function testGetViewWithoutAcceptHeader() {
		$oDefaultView = $this->state->getDefaultView();
		$this->assertInstanceOf(JsonView::class, $oDefaultView);
		$this->assertInstanceOf(ViewA::class, $oDefaultView);
	}

	public function testGetDefaultViewWithAcceptHeader() {
		$oRequest = new PopulatedRESTRequest();
		$oRequest->setHttpAccept('application/json');
		vsc::getEnv()->setHttpRequest($oRequest);

		$oDefaultView = $this->state->getView();
		$this->assertInstanceOf(JsonView::class, $oDefaultView);
		$this->assertInstanceOf(ViewA::class, $oDefaultView);

//		$oRequest->setHttpAccept('application/xml');
//		$oDefaultView = $this->state->getView();
//		$this->assertInstanceOf(XmlView::class, $oDefaultView);
//		$this->assertInstanceOf(ViewA::class, $oDefaultView);

		$oRequest->setHttpAccept('application/pdf');
		$oDefaultView = $this->state->getDefaultView();
//		$this->assertInstanceOf(StaticFileView::class, $oDefaultView);
		$this->assertInstanceOf(ViewA::class, $oDefaultView);
//
		$oRequest->setHttpAccept('image/*');
		$oDefaultView = $this->state->getDefaultView();
//		$this->assertInstanceOf(StaticFileView::class, $oDefaultView);
		$this->assertInstanceOf(ViewA::class, $oDefaultView);
	}

	public function testGetResponse () {
		$oRequest = new PopulatedRESTRequest();
		$oResponse = $this->state->getResponse($oRequest);

		$this->assertInstanceOf(HttpResponse::class, $oResponse);
		$this->assertInstanceOf(HttpResponseA::class, $oResponse);
		$this->assertEquals(HttpResponseType::INTERNAL_ERROR, $oResponse->getStatus());
		$this->assertNotEmpty($oResponse->getOutput());

		$oProcessor = new RESTProcessorFixture();
		$oResponse = $this->state->getResponse($oRequest, $oProcessor);

		$this->assertInstanceOf(HttpResponse::class, $oResponse);
		$this->assertInstanceOf(HttpResponseA::class, $oResponse);
		$this->assertEquals(HttpResponseType::METHOD_NOT_ALLOWED, $oResponse->getStatus());
		$this->assertNotEmpty($oResponse->getOutput());

		$oProcessor->setRequestMethods(array(HttpRequestTypes::GET));
		$oResponse = $this->state->getResponse($oRequest, $oProcessor);

		$this->assertInstanceOf(HttpResponse::class, $oResponse);
		$this->assertInstanceOf(HttpResponseA::class, $oResponse);
		$this->assertEquals(HttpResponseType::OK, $oResponse->getStatus());
		$this->assertNotEmpty($oResponse->getOutput());
	}

	public function testGetErrorResponse () {
		$Exception = new ExceptionController();
		$oResponse = $this->state->getErrorResponse($Exception);

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
