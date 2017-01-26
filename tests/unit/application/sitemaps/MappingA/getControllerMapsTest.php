<?php
namespace tests\application\sitemaps\MappingA;
use mocks\application\controllers\FrontControllerFixture;
use mocks\application\sitemaps\MapFixture;
use vsc\application\sitemaps\ClassMap;

/**
 * @covers \vsc\application\sitemaps\MappingA::getControllerMaps()
 */
class getControllerMaps extends \BaseUnitTest
{
	public function testInitializationEmpty()
	{
		$o = new MappingA_underTest_getControllerMaps();
		$this->assertEmpty($o->getControllerMaps());
	}

	public function testAfterSet()
	{
		$sRegex = '.*';
		$o = new MappingA_underTest_getControllerMaps();
		$o->map($sRegex, FrontControllerFixture::class);

		$aMaps = $o->getControllerMaps();
		$this->assertNotEmpty($aMaps);
		$this->assertEquals(1, count($aMaps));
		$this->assertEquals([$sRegex], array_keys($aMaps));

		$controller = $aMaps[$sRegex];
		$this->assertInstanceOf(ClassMap::class, $controller);
		$this->assertEquals(FrontControllerFixture::class, $controller->getPath());
		$this->assertEquals($sRegex, $controller->getRegex());
	}
}

class MappingA_underTest_getControllerMaps extends MapFixture {
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
