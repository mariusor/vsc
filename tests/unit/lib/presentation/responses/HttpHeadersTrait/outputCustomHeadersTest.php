<?php
namespace tests\lib\presentation\responses\HttpHeadersTrait;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpHeadersTrait::outputCustomHeaders()
 */
class outputCustomHeaders extends \BaseUnitTest
{
	public function testNullInCLI()
	{
		$o = new HttpResponseA_underTest_outputCustomHeaders();
		$this->assertFalse($o->outputCustomHeaders());
	}
}

class HttpResponseA_underTest_outputCustomHeaders extends HttpResponseA {
	public function outputCustomHeaders() {
		return parent::outputCustomHeaders();
	}
}
