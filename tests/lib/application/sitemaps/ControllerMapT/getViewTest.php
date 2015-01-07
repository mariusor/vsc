<?php
namespace tests\lib\application\sitemaps\ControllerMapT;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ControllerMapT;
use fixtures\presentation\views\NullView;
use vsc\infrastructure\Null;
use vsc\presentation\views\ViewA;

/**
 * @covers \vsc\application\sitemaps\ControllerMapT::getView()
 */
class getView extends \PHPUnit_Framework_TestCase
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

class ControllerMapT_underTest_getView extends MappingA {
	use ControllerMapT;
}
