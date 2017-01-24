<?php
namespace tests\res\presentation\requests\RawHttpRequest;
use vsc\presentation\requests\RawHttpRequest;

/**
 * @covers \vsc\presentation\requests\RawHttpRequest::getVars()
 */
class getVars extends \BaseUnitTest
{
	public function testGetVarsWithOnlyRaw()
	{
		$value = [
			'test' => uniqid('test:'),
			'brrr' => 123
		];
		$raw = json_encode($value);
		$_GET = [];
		$_POST = [];
		$_REQUEST = [];
		$_COOKIE = [];
		$_SESSION = [];
		$_SERVER = [
			'HTTP_METHOD' => 'POST',
			'CONTENT_TYPE' => 'application/json'
		];
		$o = new RawHttpRequest_underTesT_getVars($raw);
		$this->assertNotEmpty($o->getVars());
		$this->assertEquals ($value, $o->getVars());
	}
}

class RawHttpRequest_underTesT_getVars extends RawHttpRequest {
	public $raw = null;

	public function __construct ($rawInput) {
		$this->raw = $rawInput;
		parent::__construct();
	}

	public function getRawInput () {
		return $this->raw;
	}
}
