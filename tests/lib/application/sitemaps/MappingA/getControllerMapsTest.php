<?php
namespace tests\lib\application\sitemaps\MappingA;
use mocks\application\controllers\FrontControllerFixture;
use vsc\application\sitemaps\ClassMap;
use vsc\application\sitemaps\MappingA;

/**
 * @covers \vsc\application\sitemaps\MappingA::getControllerMaps()
 */
class getControllerMaps extends \PHPUnit_Framework_TestCase
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

class MappingA_underTest_getControllerMaps extends MappingA {
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
