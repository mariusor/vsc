<?php
namespace lib\application\controllers\FrontControllerA;

use fixtures\presentation\views\testView;
use vsc\application\controllers\FrontControllerA;
use vsc\application\sitemaps\ClassMap;
use vsc\infrastructure\Base;
use vsc\presentation\views\ViewA;

class getViewTest extends \PHPUnit_Framework_TestCase {
	public function setUp () {
	}

	public function tearDown () {
	}

	public function testGetViewAfterBeingSet () {
		$state = new FrontControllerA_underTest_getView();

		$oMap = new ClassMap(self::class, '\A.*\Z');
		$oMap->setView(testView::class);
		$state->setMap($oMap);

		$v = $state->getView();

		$this->assertNotNull($v);
		$this->assertNotInstanceOf(Base::class, $v);
		$this->assertInstanceOf(testView::class, $v);
		$this->assertInstanceOf(ViewA::class, $v);
	}
}

class FrontControllerA_underTest_getView extends FrontControllerA {
	/**
	 * @returns ViewA
	 */
	public function getDefaultView()
	{
		// TODO: Implement getDefaultView() method.
	}
}
