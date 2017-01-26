<?php
namespace tests\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::setContentEncoding()
 */
class setContentEncoding extends \BaseUnitTest
{
	public function testBasicSetContentEncoding()
	{
		$o = new HttpResponseA_underTest_setContentEncoding();
		$sTest = 'test';
		$o->setContentEncoding($sTest);

		$this->assertEquals($sTest, $o->getContentEncoding());
	}
}

class HttpResponseA_underTest_setContentEncoding extends HttpResponseA {}
