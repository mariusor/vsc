<?php
namespace tests\presentation\requests\RawHttpRequest;
use mocks\presentation\requests\PopulatedRawRequest;

/**
 * @covers \vsc\presentation\requests\RawHttpRequest::getRawVar()
 */
class getRawVar extends \BaseUnitTest
{
	/**
	 * @covers \vsc\presentation\requests\RawHttpRequest::getRawVar()
	 * @covers \vsc\presentation\requests\RawHttpRequest::constructRawVars()
	 */
	public function testRawGetVarJsonData()
	{
		$o = new PopulatedRawRequest();
		$testVal = array();
		$testVal['ana'] = 'mere';
		$testVal['gigel'] = 'pere';
		$testVal['random'] = uniqid('test:');

		$o->setContentType('application/json');
		$o->constructRawVars(json_encode($testVal));

		$this->assertEquals($testVal['ana'], $o->getRawVar('ana'));
		$this->assertEquals($testVal['gigel'], $o->getRawVar('gigel'));
		$this->assertEquals($testVal['random'], $o->getRawVar('random'));

		$testVal = new \stdClass();
		$testVal->ana = 'mere';
		$testVal->gigel = 'pere';
		$testVal->random = uniqid('test:');

		$o->setContentType('application/json');
		$o->constructRawVars(json_encode($testVal));

		$this->assertEquals($testVal->ana, $o->getRawVar('ana'));
		$this->assertEquals($testVal->gigel, $o->getRawVar('gigel'));
		$this->assertEquals($testVal->random, $o->getRawVar('random'));
	}
}
