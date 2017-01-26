<?php
namespace tests\presentation\requests\RawHttpRequest;
use mocks\presentation\requests\PopulatedRawRequest;

/**
 * @covers \vsc\presentation\requests\RawHttpRequest::getRawVars()
 */
class getRawVars extends \BaseUnitTest
{
	/**
	 * @covers \vsc\presentation\requests\RawHttpRequest::getRawVars()
	 * @covers \vsc\presentation\requests\RawHttpRequest::constructRawVars()
	 */
	public function testThrowExceptionEmptyContentType()
	{
		$o = new PopulatedRawRequest();
		$o->constructRawVars();

		try {
			$o->getRawVars();
		} catch (\Exception $e) {
			$this->assertInstanceOf(\Exception::class, $e);
			$this->assertInstanceOf(\vsc\Exception::class, $e);
			$this->assertInstanceOf(\vsc\presentation\ExceptionPresentation::class, $e);
			$this->assertInstanceOf(\vsc\presentation\requests\ExceptionRequest::class, $e);

			$this->assertEquals('Can not process a request with an empty content-type', $e->getMessage());
		}
	}

	/**
	 * @covers \vsc\presentation\requests\RawHttpRequest::getRawVars()
	 * @covers \vsc\presentation\requests\RawHttpRequest::constructRawVars()
	 */
	public function testThrowExceptionUnkownContentType() {
		$o = new PopulatedRawRequest();
		try {
			$o->setContentType('application/xml');
			$o->getRawVars();
		} catch (\Exception $e) {
			$this->assertInstanceOf(\Exception::class, $e);
			$this->assertInstanceOf(\vsc\presentation\ExceptionPresentation::class, $e);
			$this->assertInstanceOf(\vsc\presentation\requests\ExceptionRequest::class, $e);

			$this->assertEquals('This content-type [application/xml] is not supported', $e->getMessage());
		}
	}

	/**
	 * @covers \vsc\presentation\requests\RawHttpRequest::getRawVar()
	 * @covers \vsc\presentation\requests\RawHttpRequest::constructRawVars()
	 */
	public function testGetRawVarsJsonData()
	{
		$o = new PopulatedRawRequest();
		$testVal = array();
		$testVal['ana'] = 'mere';
		$testVal['gigel'] = 'pere';
		$testVal['random'] = uniqid('test:');

		$o->setContentType('application/json');
		$o->constructRawVars(json_encode($testVal));

		$aRawVars = $o->getRawVars();
		$this->assertEquals($testVal, $aRawVars);
		$this->assertEquals($testVal['ana'], $aRawVars['ana']);
		$this->assertEquals($testVal['gigel'], $aRawVars['gigel']);
		$this->assertEquals($testVal['random'], $aRawVars['random']);
	}
}
