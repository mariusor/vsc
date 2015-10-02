<?php
namespace tests\lib\application\sitemaps\MappingA;
use fixtures\application\controllers\FrontControllerFixture;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ModuleMap;

/**
 * @covers \vsc\application\sitemaps\MappingA::getTemplatePath()
 */
class getTemplatePath extends \PHPUnit_Framework_TestCase
{
	public function testGetTemplatePath ()
	{
		$oMap = new MappingA_underTest_getTemplatePath(FrontControllerFixture::class, '\A.*\Z');

		$oMap->setTemplatePath(VSC_FIXTURE_PATH . 'templates/');
		$oMap->setTemplate('main.tpl.php');

		$this->assertEquals(VSC_FIXTURE_PATH . 'templates/', $oMap->getTemplatePath());
	}

	public function testGetTemplatePathRelative ()
	{
		$oModuleMap = new ModuleMap(VSC_FIXTURE_PATH . 'config/map.php', '\A.*\Z');

		$oMap = new MappingA_underTest_getTemplatePath(FrontControllerFixture::class, '\A.*\Z');
		$oMap->setModuleMap($oModuleMap);

		$oMap->setTemplatePath ( 'templates/' );

		$this->assertEquals(VSC_FIXTURE_PATH . 'templates/', $oMap->getTemplatePath());
	}
}

class MappingA_underTest_getTemplatePath extends MappingA {}
