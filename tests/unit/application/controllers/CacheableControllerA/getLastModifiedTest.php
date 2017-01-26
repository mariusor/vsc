<?php
namespace tests\application\controllers\CacheableControllerA;
use mocks\presentation\views\NullView;
use vsc\application\controllers\CacheableControllerA;

/**
 * @covers \vsc\application\controllers\CacheableControllerA::getLastModified()
 */
class getLastModified extends \BaseUnitTest
{
	public function testNoLastModified()
	{
		$Controller = new CacheableController_underTest_getLastModified();
		$this->assertFalse($Controller->getLastModified());
	}
}

class CacheableController_underTest_getLastModified extends CacheableControllerA {
	public function getDefaultView () {
		return new NullView();
	}
}
