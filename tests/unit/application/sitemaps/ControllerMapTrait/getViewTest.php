<?php
namespace tests\application\sitemaps\ControllerMapTrait;
use mocks\application\sitemaps\MapFixture;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ControllerMapTrait;
use mocks\presentation\views\NullView;
use vsc\application\sitemaps\ModuleMapTrait;
use vsc\infrastructure\Base;
use vsc\presentation\views\ViewA;

/**
 * @covers \vsc\application\sitemaps\ControllerMapTrait::getView()
 */
class getView extends \BaseUnitTest
{
	public function testGetDefaultViewPath()
	{
		$o = new ControllerMapT_underTest_getViewPath(__FILE__, '.*');
		$this->assertEquals('', $o->getView());
	}

	public function testGetSetViewPath()
	{
		$o = new ControllerMapT_underTest_getViewPath(__FILE__, '.*');
		$o->setView(NullView::class);
		$this->assertInstanceOf(ViewA::class, $o->getView());
		$this->assertInstanceOf(NullView::class, $o->getView());
	}
}

class ControllerMapT_underTest_getView extends MapFixture {
	use ControllerMapTrait;
	use ModuleMapTrait;
}
