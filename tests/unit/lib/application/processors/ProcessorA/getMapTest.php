<?php
namespace tests\lib\application\processors\ProcessorA;
use mocks\application\processors\ProcessorFixture;
use vsc\application\sitemaps\ClassMap;
use vsc\application\sitemaps\ModuleMap;

/**
 * @covers \vsc\application\processors\ProcessorA::getMap()
 */
class getMap extends \BaseUnitTest
{
	public function testBasicGetMap ()
	{
		$o = new ProcessorFixture();
		$this->assertInstanceOf(ClassMap::class, $o->getMap());
	}

	public function testBasicGetMapAfterSet ()
	{
		$o = new ProcessorFixture();
		$oMap = new ModuleMap(__FILE__, '\A.*\Z');
		$o->setMap($oMap);

		$this->assertSame ($oMap, $o->getMap());
	}
}
