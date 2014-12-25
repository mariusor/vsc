<?php
namespace lib\application\controllers\CacheableControllerA;

use fixtures\presentation\views\testView;
use vsc\application\controllers\CacheableControllerA;
use vsc\application\sitemaps\ControllerMap;
use vsc\infrastructure\Null;
use vsc\presentation\views\ViewA;

class getViewTest extends \PHPUnit_Framework_TestCase {
	public function testGetViewAfterBeingSet () {
		$state = new CacheableControllerA_underTest_getView();

		$oMap = new ControllerMap(__FILE__, '\A.*\Z');
		$oMap->setView(testView::class);
		$state->setMap($oMap);

		$v = $state->getView();

		$this->assertNotNull($v);
		$this->assertNotInstanceOf(Null::class, $v);
		$this->assertInstanceOf(testView::class, $v);
		$this->assertInstanceOf(ViewA::class, $v);
	}
}

class CacheableControllerA_underTest_getView extends CacheableControllerA {
	/**
	 * @returns ViewA
	 */
	public function getDefaultView()
	{
		// TODO: Implement getDefaultView() method.
	}
}
