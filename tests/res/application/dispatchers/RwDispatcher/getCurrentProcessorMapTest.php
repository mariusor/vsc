<?php
namespace tests\res\application\dispatchers\RwDispatcher;
use vsc\application\processors\NotFoundProcessor;
use vsc\application\sitemaps\ErrorProcessorMap;
use vsc\application\dispatchers\RwDispatcher;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ClassMap;

/**
 * @covers \vsc\application\dispatchers\RwDispatcher::getCurrentProcessorMap()
 */
class getCurrentProcessorMap extends \PHPUnit_Framework_TestCase
{
	public function test404WithoutSiteMap()
	{
		$o = new RwDispatcher();
		$empty = $o->getCurrentProcessorMap();
		$this->assertInstanceOf(ClassMap::class, $empty);
		$this->assertInstanceOf(ErrorProcessorMap::class, $empty);
		$this->assertTrue(ClassMap::isValid($empty));
		$this->assertEquals(NotFoundProcessor::class, $empty->getPath());
	}

	public function testBasicGetSitemap()
	{
		$o = new RwDispatcher();
		$o->loadSiteMap(VSC_FIXTURE_PATH . 'config/map.php');

		$map = $o->getCurrentProcessorMap();
		$this->assertInstanceOf(MappingA::class, $map);
		$this->assertInstanceOf(ClassMap::class, $map);
	}
}
