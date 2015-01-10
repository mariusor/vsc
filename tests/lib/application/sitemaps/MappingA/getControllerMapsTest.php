<?php
namespace tests\lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ControllerMap;

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
		$o->mapController($sRegex,__FILE__);

		$aMaps = $o->getControllerMaps();
		$this->assertNotEmpty($aMaps);
		$this->assertEquals(1, count($aMaps));
		$this->assertEquals([$sRegex], array_keys($aMaps));

		$controller = $aMaps[$sRegex];
		$this->assertInstanceOf(ControllerMap::class, $controller);
		$this->assertEquals(__FILE__, $controller->getPath());
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
