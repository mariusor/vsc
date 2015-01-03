<?php
namespace tests\lib\application\processors\ProcessorA;
use fixtures\application\processors\ProcessorFixture;
use vsc\application\sitemaps\ModuleMap;

/**
 * @covers \vsc\application\processors\ProcessorA::setMap()
 */
class setMap extends \PHPUnit_Framework_TestCase
{
	public function testBasicSetMap () {
		$o = new ProcessorFixture();
		$oMap = new ModuleMap(__FILE__, '\A.*\Z');
		$o->setMap($oMap);

		$this->assertSame ($oMap, $o->getMap());
	}
}
