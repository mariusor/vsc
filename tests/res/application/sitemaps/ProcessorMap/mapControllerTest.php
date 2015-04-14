<?php
namespace tests\res\application\sitemaps\ProcessorMap;
use vsc\application\sitemaps\ProcessorMap;
use vsc\application\sitemaps\MappingA;

/**
 * @covers \vsc\application\sitemaps\ProcessorMap::mapController()
 */
class mapController extends \PHPUnit_Framework_TestCase
{
	public function testBasicMapController ()
	{
		$regex = '.*';
		$o = new ProcessorMap(__FILE__, '.*');
		$map = $o->mapController($regex, __FILE__);

		$this->assertInstanceOf(MappingA::class, $map);
		$this->assertEquals($regex, $map->getRegex());
		$this->assertEquals(__FILE__, $map->getPath());
	}

	public function testMapControllerWithNoRegex ()
	{
		$o = new ProcessorMap(__FILE__, '.*');
		$map = $o->mapController(__FILE__);

		$this->assertInstanceOf(MappingA::class, $map);
		$this->assertEquals($o->getRegex(), $map->getRegex());
		$this->assertEquals(__FILE__, $map->getPath());
	}
}
