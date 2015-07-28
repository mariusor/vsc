<?php
namespace tests\lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpHeaders::outputHeaders()
 */
class outputHeaders extends \PHPUnit_Framework_TestCase
{
	public function testNullInCLI()
	{
		$o = new HttpResponseA_underTest_outputHeaders();
		$this->assertFalse($o->outputHeaders());
	}
}

class HttpResponseA_underTest_outputHeaders extends HttpResponseA {}
