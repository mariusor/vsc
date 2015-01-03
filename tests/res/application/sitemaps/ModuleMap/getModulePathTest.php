<?php
namespace tests\lib\application\sitemaps\ModuleMap;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ModuleMap;

/**
 * @covers \vsc\application\sitemaps\MappingA::getModulePath()
 */
class getModulePath extends \PHPUnit_Framework_TestCase
{
	public function testGetModulePath ()
	{
		$oMap = new ModuleMap_underTest_getModulePath (VSC_FIXTURE_PATH . 'config/map.php', '\A.*\Z');

		$oMap->setTemplatePath('templates/');
		$oMap->setTemplate('main.tpl.php');

		$this->assertEquals(VSC_FIXTURE_PATH, $oMap->getModulePath());
	}
}

class ModuleMap_underTest_getModulePath extends ModuleMap {}
