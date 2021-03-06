<?php
namespace tests\application\sitemaps\ModuleMap;
use vsc\application\sitemaps\ModuleMap;

/**
 * @covers \vsc\application\sitemaps\ModuleMap::getModulePath()
 */
class getModulePath extends \BaseUnitTest
{
	public function testGetModulePath ()
	{
		$oMap = new ModuleMap (VSC_MOCK_PATH . 'config/map.php', '\A.*\Z');

		$oMap->setTemplatePath('templates/');
		$oMap->setTemplate('main.tpl.php');

		$this->assertEquals(VSC_MOCK_PATH, $oMap->getModulePath());
	}
}
