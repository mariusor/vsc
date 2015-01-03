<?php
namespace tests\lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ModuleMap;
use vsc\infrastructure\vsc;

/**
 * @covers the public method MappingA::getModulePath()
 */
class getModulePath extends \PHPUnit_Framework_TestCase
{
	public function testGetModulePathWithoutModuleSet ()
	{
		$oMap = new MappingA_underTest_getModulePath (VSC_FIXTURE_PATH . 'config/map.php', '\A.*\Z');

		$sPath = $oMap->getModulePath();
		$this->assertEquals(VSC_PATH, $sPath);
	}

	public function testGetModulePathWithModuleSet ()
	{
		$oModuleMap = new ModuleMap(VSC_FIXTURE_PATH . 'config/map.php', '\A.*\Z');

		$oMap = new MappingA_underTest_getModulePath (__FILE__, '\A.*\Z');
		$oMap->setModuleMap($oModuleMap);

		$this->assertEquals(VSC_FIXTURE_PATH, $oMap->getModulePath());
		$this->assertEquals($oModuleMap->getModulePath(), $oMap->getModulePath());
	}
}

class MappingA_underTest_getModulePath extends MappingA {}
