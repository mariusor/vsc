<?php
use fixtures\presentation\requests\PopulatedRESTRequest;
use vsc\presentation\responses\HttpResponseType;

class RESTRequestTest extends PHPUnit_Framework_TestCase {
	/**
	 * @var PopulatedRESTRequest
	 */
	public $state;

	public function setUp() {
		$this->state = new PopulatedRESTRequest();
	}

	public function tearDown() {
	}

	public function testThrowExceptionEmptyContentType()
	{
		$this->state->constructRawVars();

		try {
			$this->state->getRawVars();
		} catch (ExceptionResponseError $e) {
			$this->assertInstanceOf('\\vsc\\Exception', $e);
			$this->assertInstanceOf('\\vsc\\presentation\\ExceptionPresentation', $e);
			$this->assertInstanceOf('\\vsc\\presentation\\responses\\ExceptionResponse', $e);
			$this->assertInstanceOf('\\vsc\\presentation\\responses\\ExceptionResponseError', $e);

			$this->assertEquals('The content-type shouldn\'t be empty', $e->getMessage());
			$this->assertEquals('INPUT_ERROR', $e->getAPIErrorCode());
			$this->assertEquals(HttpResponseType::CLIENT_ERROR, $e->getErrorCode());
		}
	}

	public function testThrowExceptionUnkownContentType() {
		try {
			$this->state->setContentType('application/xml');
			$this->state->getRawVars();
		} catch (ExceptionResponseError $e) {
			$this->assertInstanceOf('\\vsc\\Exception', $e);
			$this->assertInstanceOf('\\vsc\\presentation\\ExceptionPresentation', $e);
			$this->assertInstanceOf('\\vsc\\presentation\\responses\\ExceptionResponse', $e);
			$this->assertInstanceOf('\\vsc\\presentation\\responses\\ExceptionResponseError', $e);

			$this->assertEquals('This request content-type [application/xml] is not supported', $e->getMessage());
			$this->assertEquals('INPUT_ERROR', $e->getAPIErrorCode());
			$this->assertEquals(HttpResponseType::CLIENT_ERROR, $e->getErrorCode());
		}
	}

	public function testGetRawVarsJsonData()
	{
		$testVal = array();
		$testVal['ana'] = 'mere';
		$testVal['gigel'] = 'pere';
		$testVal['random'] = uniqid('test:');

		$this->state->setContentType('application/json');
		$this->state->constructRawVars(json_encode($testVal));

		$aRawVars = $this->state->getRawVars();
		$this->assertEquals($testVal, $aRawVars);
		$this->assertEquals($testVal['ana'], $aRawVars['ana']);
		$this->assertEquals($testVal['gigel'], $aRawVars['gigel']);
		$this->assertEquals($testVal['random'], $aRawVars['random']);
	}

	public function testRawGetVarJsonData()
	{
		$testVal = array();
		$testVal['ana'] = 'mere';
		$testVal['gigel'] = 'pere';
		$testVal['random'] = uniqid('test:');

		$this->state->setContentType('application/json');
		$this->state->constructRawVars(json_encode($testVal));

		$this->assertEquals($testVal['ana'], $this->state->getRawVar('ana'));
		$this->assertEquals($testVal['gigel'], $this->state->getRawVar('gigel'));
		$this->assertEquals($testVal['random'], $this->state->getRawVar('random'));
	}

	public function testHasVarJsonData()
	{
		$testVal = array();
		$testVal['ana'] = 'mere';
		$testVal['gigel'] = 'pere';
		$testVal['random'] = uniqid('test:');

		$this->state->setContentType('application/json');
		$this->state->constructRawVars(json_encode($testVal));

		$this->assertTrue($this->state->hasVar('ana'));
		$this->assertTrue($this->state->hasVar('gigel'));
		$this->assertTrue($this->state->hasVar('random'));
	}
}
 
