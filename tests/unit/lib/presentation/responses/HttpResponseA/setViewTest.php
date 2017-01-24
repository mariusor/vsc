<?php
namespace tests\lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;
use vsc\presentation\views\JsonView;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::setView()
 */
class setView extends \BaseUnitTest
{
	public function testBasicSetView()
	{
		$o = new HttpResponseA_underTest_setView();
		$oView = new JsonView();
		$o->setView($oView);

		$this->assertSame ($oView, $o->getView());
	}
}

class HttpResponseA_underTest_setView extends HttpResponseA {}
