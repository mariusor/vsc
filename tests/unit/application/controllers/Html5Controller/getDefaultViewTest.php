<?php
namespace tests\application\controllers\Html5Controller;
use vsc\application\controllers\Html5Controller;
use vsc\presentation\views\ViewA;
use vsc\presentation\views\Html5View;

/**
 * @covers \vsc\application\controllers\Html5Controller::getDefaultView()
 */
class getDefaultView extends \BaseUnitTest
{
	public function testBasicGetDefaultView()
	{
		$s = new Html5Controller_underTest_getDefaultView();
		$this->assertInstanceOf(Html5View::class, $s->getDefaultView());
		$this->assertInstanceOf(ViewA::class, $s->getDefaultView());
	}
}

class Html5Controller_underTest_getDefaultView extends Html5Controller {
}
