<?php
use fixtures\presentation\requests\PopulatedRawRequest;

class RawHttpRequestTest extends PHPUnit_Framework_TestCase {
	/**
	 * @var PopulatedRawRequest
	 */
	public $state;

	public function setUp() {
		$this->state = new PopulatedRawRequest();
	}

	public function tearDown() {
	}

	public function testThrowExceptionEmptyContentType()
	{
		$this->state->constructRawVars();

		try {
			$this->state->getRawVars();
		} catch (Exception $e) {
			$this->assertInstanceOf(Exception::class, $e);
			$this->assertInstanceOf(\vsc\presentation\ExceptionPresentation::class, $e);
			$this->assertInstanceOf(\vsc\presentation\requests\ExceptionRequest::class, $e);

			$this->assertEquals('Can not process a request with an empty content-type', $e->getMessage());
		}
	}

	public function testThrowExceptionUnkownContentType() {
		try {
			$this->state->setContentType('application/xml');
			$this->state->getRawVars();
		} catch (Exception $e) {
			$this->assertInstanceOf(Exception::class, $e);
			$this->assertInstanceOf(\vsc\presentation\ExceptionPresentation::class, $e);
			$this->assertInstanceOf(\vsc\presentation\requests\ExceptionRequest::class, $e);

			$this->assertEquals('This content-type [application/xml] is not supported', $e->getMessage());
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

	public function testHasVarJsonData()
	{
		$testVal = array();
		$testVal['ana'] = 'mere';
		$testVal['gigel'] = 'pere';
		$testVal['random'] = uniqid('test:');

		$this->state->setContentType('application/json');
		$this->state->constructRawVars(json_encode($testVal));

		$this->assertTrue($this->state->hasRawVar('ana'));
		$this->assertTrue($this->state->hasVar('ana'));
		$this->assertTrue($this->state->hasRawVar('gigel'));
		$this->assertTrue($this->state->hasVar('gigel'));
		$this->assertTrue($this->state->hasRawVar('random'));
		$this->assertTrue($this->state->hasVar('random'));

		$testVal = new stdClass();
		$testVal->ana = 'mere';
		$testVal->gigel = 'pere';
		$testVal->random = uniqid('test:');

		$this->state->setContentType('application/json');
		$this->state->constructRawVars(json_encode($testVal));

		$this->assertTrue($this->state->hasRawVar('ana'));
		$this->assertTrue($this->state->hasVar('ana'));
		$this->assertTrue($this->state->hasRawVar('gigel'));
		$this->assertTrue($this->state->hasVar('gigel'));
		$this->assertTrue($this->state->hasRawVar('random'));
		$this->assertTrue($this->state->hasVar('random'));
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

		$testVal = new stdClass();
		$testVal->ana = 'mere';
		$testVal->gigel = 'pere';
		$testVal->random = uniqid('test:');

		$this->state->setContentType('application/json');
		$this->state->constructRawVars(json_encode($testVal));

		$this->assertEquals($testVal->ana, $this->state->getRawVar('ana'));
		$this->assertEquals($testVal->gigel, $this->state->getRawVar('gigel'));
		$this->assertEquals($testVal->random, $this->state->getRawVar('random'));
	}
}
