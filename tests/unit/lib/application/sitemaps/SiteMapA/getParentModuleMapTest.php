<?php
namespace tests\lib\application\sitemaps\SiteMapA;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ModuleMap;
use vsc\application\sitemaps\SiteMapA;

/**
 * @covers \vsc\application\sitemaps\SiteMapA::getParentModuleMap()
 */
class getParentModuleMap extends \BaseUnitTest
{
	public function testEmptyAtInitialization ()
	{
		$defaultRoot = new ModuleMap(VSC_RES_PATH.'config/map.php', '');
		$o = new SiteMapA_underTest_getParentModuleMap();
		$this->assertEquals($defaultRoot, $o->getParentModuleMap());
	}

	public function testBasicGetParentModuleMap ()
	{
		$sMapPath = VSC_MOCK_PATH . 'config/map.php';
		$sRegex = '.*';

		$o = new SiteMapA_underTest_getParentModuleMap();
		$o->map($sRegex, $sMapPath);

		// in our case the Parent Module Map is the res/config/map.php
		$oParentMap = $o->getParentModuleMap();
		$this->assertInstanceOf(MappingA::class, $oParentMap);
		$this->assertInstanceOf(ModuleMap::class, $oParentMap);
	}
}

class SiteMapA_underTest_getParentModuleMap extends SiteMapA {}
