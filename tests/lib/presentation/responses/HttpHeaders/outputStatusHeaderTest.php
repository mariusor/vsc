<?php
namespace tests\lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpHeaders::outputStatusHeader()
 */
class outputStatusHeader extends \PHPUnit_Framework_TestCase
{
	public function testNullInCLI()
	{
		$o = new HttpResponseA_underTest_outputStatusHeader();
		$this->assertFalse($o->outputStatusHeader());
	}
}

class HttpResponseA_underTest_outputStatusHeader extends HttpResponseA {
	public function outputStatusHeader() {
		return parent::outputStatusHeader();
	}
}
