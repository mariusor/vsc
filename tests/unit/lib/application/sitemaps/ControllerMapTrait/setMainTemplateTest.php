<?php
namespace tests\lib\application\sitemaps\ControllerMapTrait;
use mocks\application\sitemaps\MapFixture;
use vsc\application\sitemaps\ControllerMapTrait;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ModuleMapTrait;

/**
 * @covers \vsc\application\sitemaps\ControllerMapTrait::setMainTemplate()
 */
class setMainTemplate extends \BaseUnitTest
{
	public function testBasicGetMainTemplate()
	{
		$o = new ControllerMapT_underTest_setMainTemplate(__FILE__, '.*');
		$sValue = 'main.tpl.php';
		$o->setMainTemplate($sValue);

		$this->assertEquals($sValue, $o->getMainTemplate());
	}
}

class ControllerMapT_underTest_setMainTemplate extends MapFixture {
	use ControllerMapTrait;
	use ModuleMapTrait;
}
