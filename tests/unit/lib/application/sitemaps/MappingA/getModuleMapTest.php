<?php
namespace tests\lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ModuleMap;

/**
 * @covers \vsc\application\sitemaps\MappingA::getModuleMap()
 */
class getModuleMap extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new MappingA_underTest_getModuleMap();
		$oMap = $o->getModuleMap();
		$this->assertInstanceOf(MappingA::class, $oMap);
		$this->assertInstanceOf(ModuleMap::class, $oMap);

		$this->assertEquals(VSC_RES_PATH, $oMap->getPath());
		$this->assertEquals('', $oMap->getRegex());
	}

	public function testSetModuleMap()
	{
		$sRegex = '.*';
		$o = new MappingA_underTest_getModuleMap();
		$o->setModuleMap(new ModuleMap(__FILE__, $sRegex));

		$oMap = $o->getModuleMap();
		$this->assertInstanceOf(MappingA::class, $oMap);
		$this->assertInstanceOf(ModuleMap::class, $oMap);

		$this->assertEquals(dirname(__FILE__).DIRECTORY_SEPARATOR, $oMap->getPath());
		$this->assertEquals($sRegex, $oMap->getRegex());
	}
}

class MappingA_underTest_getModuleMap extends MappingA {
	public function __construct ($sPath = null, $sRegex = null) {
		if (is_null($sPath)) {
			$sPath = __FILE__;
		}
		if (is_null($sRegex)) {
			$sRegex = '.*';
		}
		parent::__construct($sPath, $sRegex);
	}
}
