<?php
namespace tests\lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpHeaders::outputCustomHeaders()
 */
class outputCustomHeaders extends \PHPUnit_Framework_TestCase
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
