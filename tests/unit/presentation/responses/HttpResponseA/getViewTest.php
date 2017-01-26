<?php
namespace tests\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;
use vsc\infrastructure\Base;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::getView()
 */
class getView extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new HttpResponseA_underTest_getView();

		$this->assertInstanceOf(Base::class, $o->getView());
	}
}

class HttpResponseA_underTest_getView extends HttpResponseA {}
