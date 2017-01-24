<?php
namespace tests\lib\presentation\responses\HttpHeadersTrait;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpHeadersTrait::outputLocationHeaders()
 */
class outputLocationHeaders extends \BaseUnitTest
{
	public function testNullInCLI()
	{
		$o = new HttpResponseA_underTest_outputLocationHeaders();
		$this->assertFalse($o->outputLocationHeaders());
	}
}

class HttpResponseA_underTest_outputLocationHeaders extends HttpResponseA {
	public function outputLocationHeaders() {
		return parent::outputLocationHeaders();
	}
}
