<?php
namespace tests\presentation\requests\RawHttpRequest;
use vsc\presentation\requests\RawHttpRequest;

/**
 * @covers \vsc\presentation\requests\RawHttpRequest::getVar()
 */
class getVar extends \BaseUnitTest
{
	public function testGetVarWithJustRawVar()
	{
		$value = ['test' => uniqid('test:')];
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
		$o = new RawHttpRequest_underTesT_getVar($raw);
		$this->assertNotEmpty($o->getRawVars());
		$this->assertEquals ($value['test'], $o->getVar('test'));
	}
}

class RawHttpRequest_underTesT_getVar extends RawHttpRequest {
	public $raw = null;

	public function __construct ($rawInput) {
		$this->raw = $rawInput;
		parent::__construct();
	}

	public function getRawInput () {
		return $this->raw;
	}
}
