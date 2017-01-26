<?php
namespace tests\application\sitemaps\ModuleMapTrait;
use vsc\application\sitemaps\ModuleMap;
use vsc\application\sitemaps\ModuleMapTrait;

/**
 * @covers \vsc\application\sitemaps\ModuleMapTrait::getModuleMap()
 */
class getModuleMap extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new ModuleMap_underTest_getModuleMap();
		$oMap = $o->getModuleMap();
		$this->assertInstanceOf(ModuleMap::class, $oMap);

		$this->assertEquals(VSC_SRC_PATH, $oMap->getPath());
		$this->assertEquals('', $oMap->getRegex());
	}

	public function testSetModuleMap()
	{
		$sRegex = '.*';
		$o = new ModuleMap_underTest_getModuleMap();
		$o->setModuleMap(new ModuleMap(__FILE__, $sRegex));

		$oMap = $o->getModuleMap();
		$this->assertInstanceOf(ModuleMap::class, $oMap);

		$this->assertEquals(dirname(__FILE__).DIRECTORY_SEPARATOR, $oMap->getPath());
		$this->assertEquals($sRegex, $oMap->getRegex());
	}
}

class ModuleMap_underTest_getModuleMap {
	use ModuleMapTrait;
}
