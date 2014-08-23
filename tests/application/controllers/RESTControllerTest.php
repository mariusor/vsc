<?php
use fixtures\presentation\requests\PopulatedRESTRequest;
use \avangate\application\controllers\RESTController;
use \fixtures\application\controllers\FixtureRESTController;
use \vsc\presentation\responses\HttpResponse;
use \vsc\infrastructure\Null;
use \vsc\infrastructure\vsc;
use \vsc\application\sitemaps\ClassMap;
use \vsc\domain\models\ArrayModel;
use \avangate\presentation\views\JsonView;
use \vsc\application\processors\EmptyProcessor;
use \vsc\application\controllers\ExceptionController;
use \vsc\presentation\responses\HttpResponseType;

class RESTControllerTest extends PHPUnit_Framework_TestCase {
	/**
	 * @var  RESTController
	 */
	public $state;

	public function setUp() {
		$this->state = new FixtureRESTController();

		$oMap = new ClassMap('\\fixtures\\application\\controllers\\FixtureRESTController', '.*');
		$this->state->setMap($oMap);
	}
	public function tearDown() {}

	public function testGetCacheKeyNoModel() {
		$oResponse = new HttpResponse();
		$oNull = new Null();
		$Hash = substr(sha1(':' . serialize($oNull)), 0, 8);

		$this->assertEquals('48b4524e', FixtureRESTController::getCacheKey($oResponse));
		$this->assertEquals($Hash, FixtureRESTController::getCacheKey($oResponse));
	}

	public function testGetCacheKey() {
		$oResponse = new HttpResponse();
		$oModel = new ArrayModel();
		$oView = new JsonView();

		$oView->setModel($oModel);
		$oResponse->setView($oView);

		$Hash = substr(sha1(':' . serialize($oModel)), 0, 8);
		$this->assertEquals($Hash, FixtureRESTController::getCacheKey($oResponse));

		$oModel['test'] = uniqid('test:');
		$Hash = substr(sha1(':' . serialize($oModel)), 0, 8);
		$this->assertEquals($Hash, FixtureRESTController::getCacheKey($oResponse));
	}

	public function testGetDefaultViewWithoutAcceptHeader() {
		$oDefaultView = $this->state->getDefaultView();
		$this->assertInstanceOf('\\avangate\\presentation\\views\\JsonView', $oDefaultView);
		$this->assertInstanceOf('\\vsc\\presentation\\views\\ViewA', $oDefaultView);
	}

	public function testGetDefaultViewWithAcceptHeader() {
		$oRequest = new PopulatedRESTRequest();
		$oRequest->setHttpAccept('application/json');
		vsc::getEnv()->setHttpRequest($oRequest);

		$oDefaultView = $this->state->getDefaultView();
		$this->assertInstanceOf('\\avangate\\presentation\\views\\JsonView', $oDefaultView);
		$this->assertInstanceOf('\\vsc\\presentation\\views\\ViewA', $oDefaultView);

		$oRequest->setHttpAccept('application/xml');
		$oDefaultView = $this->state->getDefaultView();
		$this->assertInstanceOf('\\avangate\\presentation\\views\\XmlView', $oDefaultView);
		$this->assertInstanceOf('\\vsc\\presentation\\views\\ViewA', $oDefaultView);

		$oRequest->setHttpAccept('application/pdf');
		$oDefaultView = $this->state->getDefaultView();
		$this->assertInstanceOf('\\avangate\\presentation\\views\\StaticFileView', $oDefaultView);
		$this->assertInstanceOf('\\vsc\\presentation\\views\\ViewA', $oDefaultView);

		$oRequest->setHttpAccept('image/*');
		$oDefaultView = $this->state->getDefaultView();
		$this->assertInstanceOf('\\avangate\\presentation\\views\\StaticFileView', $oDefaultView);
		$this->assertInstanceOf('\\vsc\\presentation\\views\\ViewA', $oDefaultView);
	}

	public function testGetResponse () {
		$oRequest = new PopulatedRESTRequest();
		$oResponse = $this->state->getResponse($oRequest);

		$this->assertInstanceOf('\\vsc\\presentation\\responses\\HttpResponse', $oResponse);
		$this->assertInstanceOf('\\vsc\\presentation\\responses\\HttpResponseA', $oResponse);
		$this->assertEquals(HttpResponseType::OK, $oResponse->getStatus());
		$this->assertNotEmpty($oResponse->getOutput());

		$oProcessor = new EmptyProcessor();
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
		$this->assertObjectHasAttribute('error_code', $oOutput);

	}
}
 