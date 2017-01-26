<?php
namespace tests\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::setLastModified()
 */
class setLastModified extends \BaseUnitTest
{
	public function testBasicSetLastModified()
	{
		$o = new HttpResponseA_underTest_setLastModified();

		$sTestValue = 'test';
		$o->setLastModified($sTestValue);

		$this->assertEquals($sTestValue, $o->getLastModified());
	}
}

class HttpResponseA_underTest_setLastModified extends HttpResponseA {}
