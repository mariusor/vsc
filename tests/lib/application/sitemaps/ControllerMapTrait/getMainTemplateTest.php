<?php
namespace tests\lib\application\sitemaps\ControllerMapTrait;
use vsc\application\sitemaps\ControllerMapTrait;
use vsc\application\sitemaps\MappingA;

/**
 * @covers \vsc\application\sitemaps\ControllerMapTrait::getMainTemplate()
 */
class getMainTemplate extends \PHPUnit_Framework_TestCase
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

class ControllerMapT_underTest_getMainTemplate extends MappingA {
	use ControllerMapTrait;
}
