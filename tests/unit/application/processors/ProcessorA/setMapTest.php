<?php
namespace tests\application\processors\ProcessorA;
use mocks\application\processors\ProcessorFixture;
use vsc\application\sitemaps\ModuleMap;

/**
 * @covers \vsc\application\processors\ProcessorA::setMap()
 */
class setMap extends \BaseUnitTest
{
	public function testBasicSetMap () {
		$o = new ProcessorFixture();
		$oMap = new ModuleMap(__FILE__, '\A.*\Z');
		$o->setMap($oMap);

		$this->assertSame ($oMap, $o->getMap());
	}
}
