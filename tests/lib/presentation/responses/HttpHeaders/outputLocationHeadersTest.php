<?php
namespace tests\lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpHeaders::outputLocationHeaders()
 */
class outputLocationHeaders extends \PHPUnit_Framework_TestCase
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
