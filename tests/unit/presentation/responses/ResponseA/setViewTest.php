<?php
namespace tests\presentation\responses\ResponseA;
use vsc\presentation\responses\ResponseA;
use vsc\presentation\views\JsonView;

/**
 * @covers \vsc\presentation\responses\ResponseA::setView()
 */
class setView extends \BaseUnitTest
{
	public function testBasicSetView()
	{
		$o = new ResponseA_underTest_setView();
		$oView = new JsonView();
		$o->setView($oView);

		$this->assertSame ($oView, $o->getView());
	}
}

class ResponseA_underTest_setView extends ResponseA {}
