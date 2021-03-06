<?php
namespace tests\presentation\responses\HttpHeadersTrait;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpHeadersTrait::outputContentHeaders()
 */
class outputContentHeaders extends \BaseUnitTest
{
	public function testNullInCLI()
	{
		$o = new HttpResponseA_underTest_outputContentHeaders();
		$this->assertFalse($o->outputContentHeaders());
	}
}

class HttpResponseA_underTest_outputContentHeaders extends HttpResponseA {
	public function outputContentHeaders() {
		return parent::outputContentHeaders();
	}
}
