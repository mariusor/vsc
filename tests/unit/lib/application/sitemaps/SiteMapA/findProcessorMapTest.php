<?php
namespace lib\application\sitemaps\SiteMapA;


use mocks\application\processors\ProcessorFixture;
use vsc\application\sitemaps\ClassMap;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\SiteMapA;

class findProcessorMap extends \PHPUnit_Framework_TestCase
{

	public function testEmptyAtInitialization ()
	{
		$o = new SiteMapA_underTest_findProcessorMap();
		$p = new ProcessorFixture();

		$this->assertNull($o->findProcessorMap($p));
	}

	public function testWithAMappedProcessor ()
	{
		$o = new SiteMapA_underTest_findProcessorMap();
		$p = new ProcessorFixture();
		$regex = '.*';

		$o->map($regex, get_class($p));
		$map = $o->findProcessorMap($p);
		$this->assertInstanceOf(ClassMap::class, $map);
		$this->assertInstanceOf(MappingA::class, $map);
		$this->assertEquals($regex, $map->getRegex());
		$this->assertEquals(ProcessorFixture::class, $map->getPath());
	}
}

class SiteMapA_underTest_findProcessorMap extends SiteMapA { }
