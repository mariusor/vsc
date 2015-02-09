<?php
namespace tests\res\domain\models\JsonRPCRequest;
use vsc\domain\models\JsonRPCRequest;
use vsc\infrastructure\vsc;
use vsc\presentation\requests\RawHttpRequest;

/**
 * @covers \vsc\domain\models\JsonRPCRequest::__construct()
 */
class __construct extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		vsc::getEnv()->setHttpRequest(new RawHttpRequest_underTest___construct());

		$_SERVER['CONTENT_TYPE'] = 'application/json';

		$o = new JsonRPCRequest();
		$this->assertEmpty($o->id);
		$this->assertEmpty($o->method);
		$this->assertEmpty($o->params);
	}
}

class RawHttpRequest_underTest___construct extends RawHttpRequest {
	protected function getRawInput () {
		return '[]';
	}
}
