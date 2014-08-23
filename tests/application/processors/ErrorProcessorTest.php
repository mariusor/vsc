<?php
use  avangate\application\processors\ErrorProcessor;
use vsc\application\sitemaps\ClassMap;
use vsc\ExceptionError;
use vsc\presentation\responses\HttpResponseType;
use \avangate\presentation\responses\ExceptionResponseError;

class ErrorProcessorTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @var  ErrorProcessor
	 */
	public $state;

	public function setUp() {
		$Exception = new ExceptionError('test', 123);
		$this->state = new ErrorProcessor($Exception);

		$oMap = new ClassMap('\\avangate\\application\\processors\\ErrorProcessor', '.*');
		$this->state->setMap($oMap);
	}
	public function tearDown() {}

	public function testGetModel () {
		$this->assertInstanceOf('\\avangate\\domain\\models\\ErrorModel', $this->state->getModel());

		$this->assertEquals('test', $this->state->getModel()->getMessage());
		$this->assertEquals(HttpResponseType::INTERNAL_ERROR, $this->state->getModel()->getHttpStatus());
	}

	public function testSetException () {
		$sMessage = uniqid('MESSAGE:');
		$sCode = uniqid('CODE:');
		$iError = HttpResponseType::CLIENT_ERROR;
		$Exception = new ExceptionResponseError($sMessage, $sCode, $iError);

		$this->state->setException($Exception);
		$this->assertInstanceOf('\\avangate\\domain\\models\\ErrorModel', $this->state->getModel());

		$this->assertEquals($sMessage, $this->state->getModel()->getMessage());
		$this->assertEquals($sCode, $this->state->getModel()->getCode());
		$this->assertEquals($iError, $this->state->getModel()->getHttpStatus());
	}

	public function testGetException () {
		$sMessage = uniqid('MESSAGE:');
		$sCode = uniqid('CODE:');
		$iError = HttpResponseType::CLIENT_ERROR;
		$this->state->setException(new ExceptionResponseError($sMessage, $sCode, $iError));

		$oModel = $this->state->getModel();
		$this->assertInstanceOf('\\avangate\\domain\\models\\ErrorModel', $oModel);

		$Exception = $oModel->getException();
		$this->assertInstanceOf('\\avangate\\presentation\\responses\\ExceptionResponseError', $Exception);
		$this->assertInstanceOf('\\vsc\\presentation\\responses\\ExceptionResponseError', $Exception);
		$this->assertInstanceOf('\\vsc\\presentation\\responses\\ExceptionResponse', $Exception);
		$this->assertInstanceOf('\\vsc\\presentation\\ExceptionPresentation', $Exception);
	}

}
 