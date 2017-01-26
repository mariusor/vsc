<?php
namespace tests\application\sitemaps\ModuleMapTrait;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ModuleMap;
use vsc\application\sitemaps\ModuleMapTrait;

/**
 * @covers \vsc\application\sitemaps\ModuleMapTrait::setModuleMap()
 */
class setModuleMap extends \BaseUnitTest
{

	public function testSetModuleMap()
	{
		$sRegex = '.*';
		$o = new ModuleMap_underTest_setModuleMap();
		$o->setModuleMap(new ModuleMap(__FILE__, $sRegex));

		$oMap = $o->getModuleMap();
		$this->assertInstanceOf(MappingA::class, $oMap);
		$this->assertInstanceOf(ModuleMap::class, $oMap);

		$this->assertEquals(dirname(__FILE__).DIRECTORY_SEPARATOR, $oMap->getPath());
		$this->assertEquals($sRegex, $oMap->getRegex());
	}
}

class ModuleMap_underTest_setModuleMap {
	use ModuleMapTrait;
}
