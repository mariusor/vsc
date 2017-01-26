<?php
namespace tests\lib\application\sitemaps\MappingA;
use mocks\application\controllers\FrontControllerFixture;
use mocks\application\sitemaps\MapFixture;
use vsc\application\sitemaps\ModuleMap;
use vsc\application\sitemaps\ModuleMapTrait;

/**
 * @covers \vsc\application\sitemaps\MappingA::getTemplatePath()
 */
class getTemplatePath extends \BaseUnitTest
{
	public function testGetTemplatePath ()
	{
		$oMap = new MappingA_underTest_getTemplatePath(FrontControllerFixture::class, '\A.*\Z');

		$oMap->setTemplatePath(VSC_MOCK_PATH . 'templates/');
		$oMap->setTemplate('main.tpl.php');

		$this->assertEquals(VSC_MOCK_PATH . 'templates/', $oMap->getTemplatePath());
	}

	public function testGetTemplatePathRelative ()
	{
		$oModuleMap = new ModuleMap(VSC_MOCK_PATH . 'config/map.php', '\A.*\Z');

		$oMap = new MappingA_underTest_getTemplatePath(FrontControllerFixture::class, '\A.*\Z');
		$oMap->setModuleMap($oModuleMap);

		$oMap->setTemplatePath ( 'templates/' );

		$this->assertEquals(VSC_MOCK_PATH . 'templates/', $oMap->getTemplatePath());
	}
}

class MappingA_underTest_getTemplatePath extends MapFixture {
	use ModuleMapTrait;
}
