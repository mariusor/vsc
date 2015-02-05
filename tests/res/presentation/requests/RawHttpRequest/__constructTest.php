<?php
namespace tests\res\presentation\requests\RawHttpRequest;
use vsc\presentation\requests\RawHttpRequest;

/**
 * @covers \vsc\presentation\requests\RawHttpRequest::__construct()
 */
class __construct extends \PHPUnit_Framework_TestCase
{
	public function testBasic__construct()
	{
		$_SERVER = [
			'HTTP_METHOD' => 'POST',
			'CONTENT_TYPE' => 'application/json'
		];
		$o = new RawHttpRequest();
		$this->assertEmpty($o->getRawVars());
	}
}
