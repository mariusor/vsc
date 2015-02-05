<?php
namespace tests\res\application\dispatchers\RwDispatcher;
use fixtures\application\controllers\GenericFrontController;
use vsc\application\controllers\FrontControllerA;
use vsc\application\dispatchers\RwDispatcher;
use vsc\application\sitemaps\ClassMap;
use vsc\application\sitemaps\ExceptionSitemap;
use vsc\application\sitemaps\MappingA;

/**
 * @covers \vsc\application\dispatchers\RwDispatcher::getCurrentControllerMap()
 */
class getCurrentControllerMap extends \PHPUnit_Framework_TestCase
{
	public function testFailsWithoutSiteMap()
	{
		$o = new RwDispatcher();
		try {
			$this->assertEmpty($o->getCurrentControllerMap());
		} catch (\Exception $e) {
			$this->assertInstanceOf(ExceptionSitemap::class, $e);
		}
	}

	public function testBasicGetSitemap()
	{
		$o = new RwDispatcher();
		$o->loadSiteMap(VSC_FIXTURE_PATH . 'config/map.php');

		$map = $o->getCurrentControllerMap();
		$this->assertInstanceOf(MappingA::class, $map);
		$this->assertInstanceOf(ClassMap::class, $map);
	}
}
