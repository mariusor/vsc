<?php
namespace tests\lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::setETag()
 */
class setETag extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$o = new HttpResponseA_underTest_setExpires();
		$sTest = 'test';
		$o->setETag($sTest);

		$this->assertEquals($sTest, $o->getETag());
	}
}

class HttpResponseA_underTest_setETag extends HttpResponseA {}