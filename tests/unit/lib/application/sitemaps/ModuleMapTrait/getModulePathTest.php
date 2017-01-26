<?php
namespace tests\lib\application\sitemaps\ModuleMapTrait;
use vsc\application\sitemaps\ModuleMap;
use vsc\application\sitemaps\ModuleMapTrait;

/**
 * @covers \vsc\application\sitemaps\ModuleMapTrait::getModulePath()
 */
class getModulePath extends \BaseUnitTest
{
	public function testGetModulePathWithoutModuleSet ()
	{
		$oMap = new ModuleMap_underTest_getModulePath (VSC_MOCK_PATH . 'config/map.php', '\A.*\Z');

		$sPath = $oMap->getModulePath();
		$this->assertEquals(VSC_RES_PATH, $sPath);
	}

	public function testGetModulePathWithModuleSet ()
	{
		$oModuleMap = new ModuleMap(VSC_MOCK_PATH . 'config/map.php', '\A.*\Z');

		$oMap = new ModuleMap_underTest_getModulePath (__FILE__, '\A.*\Z');
		$oMap->setModuleMap($oModuleMap);

		$this->assertEquals(VSC_MOCK_PATH, $oMap->getModulePath());
		$this->assertEquals($oModuleMap->getModulePath(), $oMap->getModulePath());
	}
}

class ModuleMap_underTest_getModulePath {
	use ModuleMapTrait;
}
