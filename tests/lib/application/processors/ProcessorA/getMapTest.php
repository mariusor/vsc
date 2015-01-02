<?php
namespace tests\lib\application\processors\ProcessorA;
use fixtures\application\processors\ProcessorFixture;
use vsc\application\sitemaps\ModuleMap;

/**
 * @covers the public method ProcessorA::getMap()
 */
class getMap extends \PHPUnit_Framework_TestCase
{
	public function testBasicGetMap ()
	{
		$o = new ProcessorFixture();
		$this->assertInstanceOf(\vsc\application\sitemaps\ProcessorMap::class, $o->getMap());
	}

	public function testBasicGetMapAfterSet ()
	{
		$o = new ProcessorFixture();
		$oMap = new ModuleMap(__FILE__, '\A.*\Z');
		$o->setMap($oMap);

		$this->assertSame ($oMap, $o->getMap());
	}
}
