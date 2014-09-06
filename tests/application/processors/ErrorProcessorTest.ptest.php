<?php
use vsc\application\processors\ErrorProcessor;
use vsc\application\sitemaps\ClassMap;
use vsc\ExceptionError;
use vsc\presentation\responses\HttpResponseType;
use \vsc\presentation\responses\ExceptionResponseError;

class ErrorProcessorTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @var  ErrorProcessor
	 */
	public $state;

	public function setUp() {
		$Exception = new ExceptionError('test', 123);
		$this->state = new ErrorProcessor($Exception);

		$oMap = new ClassMap(ErrorProcessor::class, '.*');
		$this->state->setMap($oMap);
	}
	public function tearDown() {}

	public function testGetModel () {
		$this->assertInstanceOf(\vsc\domain\models\ErrorModel::class, $this->state->getModel());

		$this->assertEquals('test', $this->state->getModel()->getMessage());
		$this->assertEquals(HttpResponseType::INTERNAL_ERROR, $this->state->getModel()->getHttpStatus());
	}

	public function testSetException () {
		$sMessage = uniqid('MESSAGE:');
		$sCode = uniqid('CODE:');
		$iError = HttpResponseType::CLIENT_ERROR;
		$Exception = new ExceptionResponseError($sMessage, $iError);

		$this->state->setException($Exception);
		$this->assertInstanceOf(\vsc\domain\models\ErrorModel::class, $this->state->getModel());

		$this->assertEquals($sMessage, $this->state->getModel()->getMessage());
		$this->assertEquals($iError, $this->state->getModel()->getHttpStatus());
	}

	public function testGetException () {
		$sMessage = uniqid('MESSAGE:');
		$sCode = uniqid('CODE:');
		$iError = HttpResponseType::CLIENT_ERROR;
		$this->state->setException(new ExceptionResponseError($sMessage, $iError));

		$oModel = $this->state->getModel();
		$this->assertInstanceOf(\vsc\domain\models\ErrorModel::class, $oModel);

		$Exception = $oModel->getException();
		$this->assertInstanceOf(ExceptionResponseError::class, $Exception);
		$this->assertInstanceOf(\vsc\presentation\responses\ExceptionResponse::class, $Exception);
		$this->assertInstanceOf(\vsc\presentation\ExceptionPresentation::class, $Exception);
	}

}