<?php
namespace tests\res\presentation\requests\RawHttpRequest;
use fixtures\presentation\requests\PopulatedRawRequest;

/**
 * @covers \vsc\presentation\requests\RawHttpRequest::hasRawVar()
 */
class hasRawVar extends \PHPUnit_Framework_TestCase
{
	/**
	 * @covers \vsc\presentation\requests\RawHttpRequest::hasRawVar()
	 * @covers \vsc\presentation\requests\RawHttpRequest::hasVar()
	 * @covers \vsc\presentation\requests\RawHttpRequest::constructRawVars()
	 */
	public function testHasVarJsonData()
	{
		$o = new PopulatedRawRequest();
		$testVal = array();
		$testVal['ana'] = 'mere';
		$testVal['gigel'] = 'pere';
		$testVal['random'] = uniqid('test:');

		$o->setContentType('application/json');
		$o->constructRawVars(json_encode($testVal));

		$this->assertTrue($o->hasRawVar('ana'));
		$this->assertTrue($o->hasVar('ana'));
		$this->assertTrue($o->hasRawVar('gigel'));
		$this->assertTrue($o->hasVar('gigel'));
		$this->assertTrue($o->hasRawVar('random'));
		$this->assertTrue($o->hasVar('random'));

		$testVal = new \stdClass();
		$testVal->ana = 'mere';
		$testVal->gigel = 'pere';
		$testVal->random = uniqid('test:');

		$o->setContentType('application/json');
		$o->constructRawVars(json_encode($testVal));

		$this->assertTrue($o->hasRawVar('ana'));
		$this->assertTrue($o->hasVar('ana'));
		$this->assertTrue($o->hasRawVar('gigel'));
		$this->assertTrue($o->hasVar('gigel'));
		$this->assertTrue($o->hasRawVar('random'));
		$this->assertTrue($o->hasVar('random'));
	}
}
