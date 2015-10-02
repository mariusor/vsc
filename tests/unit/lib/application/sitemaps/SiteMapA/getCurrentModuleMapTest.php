<?php
namespace tests\lib\application\sitemaps\SiteMapA;
use vsc\application\sitemaps\SiteMapA;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ModuleMap;

/**
 * @covers \vsc\application\sitemaps\SiteMapA::getCurrentModuleMap()
 */
class getCurrentModuleMap extends \PHPUnit_Framework_TestCase
{
	public function testBasicGetParentModuleMap ()
	{
		$sMapPath = VSC_MOCK_PATH . 'config/map.php';
		$sRegex = '.*';

		$o = new SiteMapA_underTest_getCurrentModuleMap();
		$o->map($sRegex, $sMapPath);

		// in our case the Parent Module Map is the res/config/map.php
		$oParentMap = $o->getParentModuleMap();
		$this->assertInstanceOf(MappingA::class, $oParentMap);
		$this->assertInstanceOf(ModuleMap::class, $oParentMap);
	}
}

class SiteMapA_underTest_getCurrentModuleMap extends SiteMapA {}
