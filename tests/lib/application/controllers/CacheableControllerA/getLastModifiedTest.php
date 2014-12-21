<?php
namespace tests\lib\application\controllers\CacheableControllerA;
use vsc\application\controllers\CacheableControllerA;
use vsc\presentation\views\ViewA;

/**
 * @covers the public method CacheableControllerA::getLastModified()
 */
class getLastModified extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$Controller = new CacheableController_underTest_getLastModified();

		$this->assertFalse($Controller->getLastModified());
	}
}

class CacheableController_underTest_getLastModified extends CacheableControllerA {

	/**
	 * @returns ViewA
	 */
	public function getDefaultView () {
		return new \DefaultViewTest();
	}
}
