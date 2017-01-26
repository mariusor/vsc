<?php
namespace tests\application\dispatchers\RwDispatcher;
use vsc\application\processors\ErrorProcessor;
use vsc\application\sitemaps\ErrorProcessorMap;
use vsc\application\dispatchers\RwDispatcher;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ClassMap;

/**
 * @covers \vsc\application\dispatchers\RwDispatcher::getCurrentProcessorMap()
 */
class getCurrentProcessorMap extends \BaseUnitTest
{
	public function test404WithoutSiteMap()
	{
		$o = new RwDispatcher();
		$empty = $o->getCurrentProcessorMap();
		$this->assertInstanceOf(ClassMap::class, $empty);
		$this->assertInstanceOf(ErrorProcessorMap::class, $empty);
		$this->assertTrue(ClassMap::isValid($empty));
		$this->assertEquals(ErrorProcessor::class, $empty->getPath());
	}

	public function testBasicGetSitemap()
	{
		$o = new RwDispatcher();
		$o->loadSiteMap(VSC_MOCK_PATH . 'config/map.php');

		$map = $o->getCurrentProcessorMap();
		$this->assertInstanceOf(MappingA::class, $map);
		$this->assertInstanceOf(ClassMap::class, $map);
	}
}
