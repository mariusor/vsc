<?php
namespace tests\lib\application\processors\ProcessorA;
use fixtures\application\processors\ProcessorFixture;
use vsc\application\sitemaps\ModuleMap;
use vsc\application\sitemaps\ProcessorMap;

/**
 * @covers \vsc\application\processors\ProcessorA::getMap()
 */
class getMap extends \PHPUnit_Framework_TestCase
{
	public function testBasicGetMap ()
	{
		$o = new ProcessorFixture();
		$this->assertInstanceOf(ProcessorMap::class, $o->getMap());
	}

	public function testBasicGetMapAfterSet ()
	{
		$o = new ProcessorFixture();
		$oMap = new ModuleMap(__FILE__, '\A.*\Z');
		$o->setMap($oMap);

		$this->assertSame ($oMap, $o->getMap());
	}
}
