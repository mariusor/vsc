<?php
namespace tests\lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;
use vsc\infrastructure\Null;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::getView()
 */
class getView extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new HttpResponseA_underTest_getView();

		$this->assertInstanceOf(Null::class, $o->getView());
	}
}

class HttpResponseA_underTest_getView extends HttpResponseA {}