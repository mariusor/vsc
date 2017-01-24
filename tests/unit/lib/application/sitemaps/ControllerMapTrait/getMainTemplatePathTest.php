<?php
namespace tests\lib\application\sitemaps\ControllerMapTrait;
use mocks\application\controllers\FrontControllerFixture;
use vsc\application\sitemaps\ControllerMapTrait;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ModuleMap;

/**
 * @covers \vsc\application\sitemaps\ControllerMapTrait::getMainTemplatePath()
 */
class getMainTemplatePath extends \BaseUnitTest
{
	public function testGetMainTemplatePath ()
	{
		$oMap = new ControllerMapT_underTest_getMainTemplatePath(FrontControllerFixture::class, '\A.*\Z');

		$oMap->setMainTemplatePath(VSC_MOCK_PATH . 'templates/');
		$oMap->setTemplate('main.tpl.php');

		$this->assertEquals(VSC_MOCK_PATH . 'templates/', $oMap->getMainTemplatePath());
	}

	public function testGetMainTemplatePathRelative ()
	{
		$oModuleMap = new ModuleMap(VSC_MOCK_PATH . 'config/map.php', '\A.*\Z');

		$oMap = new ControllerMapT_underTest_getMainTemplatePath(FrontControllerFixture::class, '\A.*\Z');
		$oMap->setModuleMap($oModuleMap);

		$oMap->setMainTemplatePath ( 'templates/' );

		$this->assertEquals(VSC_MOCK_PATH . 'templates/', $oMap->getMainTemplatePath());
	}
}

class ControllerMapT_underTest_getMainTemplatePath extends MappingA {
	use ControllerMapTrait;
}
