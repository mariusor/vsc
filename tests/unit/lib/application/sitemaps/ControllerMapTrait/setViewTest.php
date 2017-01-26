<?php
namespace tests\lib\application\sitemaps\ControllerMapTrait;
use mocks\application\sitemaps\MapFixture;
use mocks\presentation\views\NullView;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ControllerMapTrait;
use vsc\application\sitemaps\ModuleMapTrait;
use vsc\presentation\views\ViewA;

/**
 * @covers \vsc\application\sitemaps\ControllerMapTrait::setView()
 */
class setView extends \BaseUnitTest
{
	public function testGetDefaultViewPath()
	{
		$o = new ControllerMapT_underTest_getViewPath(__FILE__, '.*');
		$this->assertEquals('', $o->getView());
	}

	public function testSetViewPath()
	{
		$o = new ControllerMapT_underTest_getViewPath(__FILE__, '.*');
		$o->setView(NullView::class);
		$this->assertInstanceOf(ViewA::class, $o->getView());
		$this->assertInstanceOf(NullView::class, $o->getView());
	}
}

class ControllerMapT_underTest_setView extends MapFixture {
	use ControllerMapTrait;
	use ModuleMapTrait;
}
