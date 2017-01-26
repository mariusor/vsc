<?php
namespace tests\application\dispatchers\RwDispatcher;
use vsc\application\dispatchers\RwDispatcher;
use vsc\application\sitemaps\ClassMap;
use vsc\application\sitemaps\ErrorControllerMap;
use vsc\application\sitemaps\MappingA;

/**
 * @covers \vsc\application\dispatchers\RwDispatcher::getCurrentControllerMap()
 */
class getCurrentControllerMap extends \BaseUnitTest
{
	public function testServeHtml5WithoutSiteMap()
	{
		$o = new RwDispatcher();
		$this->assertInstanceOf(ErrorControllerMap::class, $o->getCurrentControllerMap());
	}

	public function testBasicGetSitemap()
	{
		$o = new RwDispatcher();
		$o->loadSiteMap(VSC_MOCK_PATH . 'config/map.php');

		$map = $o->getCurrentControllerMap();
		$this->assertInstanceOf(MappingA::class, $map);
		$this->assertInstanceOf(ClassMap::class, $map);
	}
}
