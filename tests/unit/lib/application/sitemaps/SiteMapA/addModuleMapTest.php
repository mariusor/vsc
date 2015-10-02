<?php
namespace tests\lib\application\sitemaps\SiteMapA;
use vsc\application\sitemaps\SiteMapA;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ModuleMap;

/**
 * @covers \vsc\application\sitemaps\SiteMapA::addModuleMap()
 */
class addModuleMap extends \PHPUnit_Framework_TestCase
{
	public function testBasicAddModuleMap()
	{
		$o = new SiteMapA_underTest_addModuleMap();
		$oModuleMap = $o->addModuleMap('.*', VSC_MOCK_PATH . 'config/map.php');

		$this->assertInstanceOf(MappingA::class, $oModuleMap);
		$this->assertInstanceOf(ModuleMap::class, $oModuleMap);
	}
}

class SiteMapA_underTest_addModuleMap extends SiteMapA {}
