<?php
namespace tests\presentation\requests\RawHttpRequest;
use vsc\presentation\requests\RawHttpRequest;

/**
 * @covers \vsc\presentation\requests\RawHttpRequest::setRawVars()
 */
class setRawVars extends \BaseUnitTest
{
	public function testSetVarsWithOnlyRaw()
	{
		$_GET = [];
		$_POST = [];
		$_REQUEST = [];
		$_COOKIE = [];
		$_SESSION = [];
		$_SERVER = [
			'HTTP_METHOD' => 'POST',
			'CONTENT_TYPE' => 'application/json'
		];

		$o = new RawHttpRequest ();
		$this->assertEmpty($o->getVars());

		$value = [
			'test' => uniqid('test:'),
			'brrr' => 123
		];
		$o->setRawVars($value);
		$this->assertNotEmpty($o->getVars());
		$this->assertEquals ($value, $o->getVars());
	}
}

