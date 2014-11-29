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

		$oMap = new ClassMap('\\fixtures\\application\\controllers\\FixtureRESTController', '.*');
		$this->state->setMap($oMap);
	}

	public function tearDown() {
		vsc::setInstance(new vsc);
	}

	public function testGetViewWithoutAcceptHeader() {
		$oDefaultView = $this->state->getDefaultView();
		$this->assertInstanceOf('\\vsc\\presentation\\views\\JsonView', $oDefaultView);
		$this->assertInstanceOf('\\vsc\\presentation\\views\\ViewA', $oDefaultView);
	}

	public function testGetDefaultJsonViewWithAcceptHeader() {
		$oRequest = new PopulatedRESTRequest();
		$oRequest->setContentType( 'application/json' );
		vsc::getEnv ()->setHttpRequest ( $oRequest );

		$oDefaultView = $this->state->getView ();
		$this->assertInstanceOf ( '\\vsc\\presentation\\views\\JsonView', $oDefaultView );
		$this->assertInstanceOf ( '\\vsc\\presentation\\views\\ViewA', $oDefaultView );
	}

//	public function testGetDefaultXmlViewWithAcceptHeader() {
//		$oRequest = new PopulatedRESTRequest();
//		$oRequest->setContentType('application/xml');
//		vsc::getEnv ()->setHttpRequest ( $oRequest );
//
//		$oDefaultView = $this->state->getView();
//		$this->assertInstanceOf('\\vsc\\presentation\\views\\XmlView', $oDefaultView);
//		$this->assertInstanceOf('\\vsc\\presentation\\views\\ViewA', $oDefaultView);
//	}

	public function testGetResponseInternalError () {
		$oRequest = new PopulatedRESTRequest();
		$oResponse = $this->state->getResponse ( $oRequest );

		$this->assertInstanceOf ( '\\vsc\\presentation\\responses\\HttpResponse', $oResponse );
		$this->assertInstanceOf ( '\\vsc\\presentation\\responses\\HttpResponseA', $oResponse );
		$this->assertEquals ( HttpResponseType::INTERNAL_ERROR, $oResponse->getStatus () );
		$this->assertNotEmpty ( $oResponse->getOutput () );
	}

	public function testGetResponseMethodNotAllowed () {
		$oRequest = new PopulatedRESTRequest();
		$oProcessor = new RESTProcessorFixture();
		$oResponse = $this->state->getResponse($oRequest, $oProcessor);

		$this->assertInstanceOf('\\vsc\\presentation\\responses\\HttpResponse', $oResponse);
		$this->assertInstanceOf('\\vsc\\presentation\\responses\\HttpResponseA', $oResponse);
		$this->assertEquals(HttpResponseType::METHOD_NOT_ALLOWED, $oResponse->getStatus());
		$this->assertNotEmpty($oResponse->getOutput());
	}

	public function testGetResponseOK () {
		$oRequest = new PopulatedRESTRequest();
		$oProcessor = new RESTProcessorFixture();
		$oProcessor->setRequestMethods(array(HttpRequestTypes::GET));
		$oResponse = $this->state->getResponse($oRequest, $oProcessor);

		$this->assertInstanceOf('\\vsc\\presentation\\responses\\HttpResponse', $oResponse);
		$this->assertInstanceOf('\\vsc\\presentation\\responses\\HttpResponseA', $oResponse);
		$this->assertEquals(HttpResponseType::OK, $oResponse->getStatus());
		$this->assertNotEmpty($oResponse->getOutput());
	}

	public function testGetErrorResponse () {
		$Exception = new ExceptionController();
		$oResponse = $this->state->getErrorResponse($Exception);

		$this->assertInstanceOf('\\vsc\\presentation\\responses\\HttpResponse', $oResponse);
		$this->assertInstanceOf('\\vsc\\presentation\\responses\\HttpResponseA', $oResponse);
		$this->assertEquals(HttpResponseType::INTERNAL_ERROR, $oResponse->getStatus());
		$this->assertNotEquals(HttpResponseType::OK, $oResponse->getStatus());

		$sOutput = $oResponse->getOutput();
		$this->assertNotEmpty($sOutput);

		$oOutput = json_decode($sOutput);
		$this->assertInstanceOf('\\stdClass', $oOutput);
		$this->assertObjectHasAttribute('message', $oOutput);
		$this->assertEquals('', $oOutput->message);
	}
}
