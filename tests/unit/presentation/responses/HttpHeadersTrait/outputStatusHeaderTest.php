<?php
namespace tests\presentation\responses\HttpHeadersTrait;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpHeadersTrait::outputStatusHeader()
 */
class outputStatusHeader extends \BaseUnitTest
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
