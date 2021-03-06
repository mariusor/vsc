<?php
namespace tests\application\sitemaps\ControllerMapTrait;
use mocks\application\sitemaps\MapFixture;
use vsc\application\sitemaps\ControllerMapTrait;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ModuleMapTrait;

/**
 * @covers \vsc\application\sitemaps\ControllerMapTrait::getMainTemplate()
 */
class getMainTemplate extends \BaseUnitTest
{
	public function testGetDefaultMainTemplate ()
	{
		$o = new ControllerMapT_underTest_getMainTemplate(__FILE__, '.*');
		$this->assertEquals('main.php', $o->getMainTemplate());
	}

	public function testGetSetMainTemplate ()
	{
		$o = new ControllerMapT_underTest_getMainTemplate(__FILE__, '.*');

		$sValue = uniqid('main') . '.php';
		$o->setMainTemplate($sValue);
		$this->assertEquals($sValue, $o->getMainTemplate());
	}
}

class ControllerMapT_underTest_getMainTemplate extends MapFixture {
	use ModuleMapTrait;
	use ControllerMapTrait;
}
