<?php
namespace tests\application\dispatchers\RwDispatcher;
use vsc\application\dispatchers\RwDispatcher;

/**
 * @covers \vsc\application\dispatchers\RwDispatcher::getView()
 */
class getView extends \BaseUnitTest
{
	public function testUseless()
	{
		$o = new RwDispatcher();
		$this->assertEmpty($o->getView());
	}
}
