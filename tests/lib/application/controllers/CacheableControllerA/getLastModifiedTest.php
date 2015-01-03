<?php
namespace tests\lib\application\controllers\CacheableControllerA;
use fixtures\presentation\views\NullView;
use vsc\application\controllers\CacheableControllerA;

/**
 * @covers \vsc\application\controllers\CacheableControllerA::getLastModified()
 */
class getLastModified extends \PHPUnit_Framework_TestCase
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
