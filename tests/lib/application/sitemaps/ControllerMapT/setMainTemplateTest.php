<?php
namespace tests\lib\application\sitemaps\ControllerMapT;
use vsc\application\sitemaps\ControllerMapT;
use vsc\application\sitemaps\MappingA;

/**
 * @covers \vsc\application\sitemaps\ControllerMapT::setMainTemplate()
 */
class setMainTemplate extends \PHPUnit_Framework_TestCase
{
	public function testBasicGetMainTemplate()
	{
		$o = new ControllerMapT_underTest_setMainTemplate(__FILE__, '.*');
		$sValue = 'main.tpl.php';
		$o->setMainTemplate($sValue);

		$this->assertEquals($sValue, $o->getMainTemplate());
	}
}

class ControllerMapT_underTest_setMainTemplate extends MappingA {
	use ControllerMapT;
}
