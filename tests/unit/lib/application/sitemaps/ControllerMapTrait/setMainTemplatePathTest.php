<?php
namespace tests\lib\application\sitemaps\ControllerMapTrait;
use mocks\application\controllers\FrontControllerFixture;
use vsc\application\sitemaps\ControllerMapTrait;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ModuleMap;
use vsc\Exception;
use vsc\ExceptionPath;

/**
 * @covers \vsc\application\sitemaps\ControllerMapTrait::setMainTemplatePath()
 */
class setMainTemplatePath extends \BaseUnitTest
{
	public function testSetMainTemplatePathRelativeNoModuleMap ()
	{
		$oMap = new ControllerMapT_underTest_setMainTemplatePath (FrontControllerFixture::class, '\A.*\Z');

		try {
			$oMap->setMainTemplatePath ( 'templates/' );
		} catch (\Exception $e) {
			// no module map for the relative path to work
			$this->assertInstanceOf(\Exception::class, $e);
			$this->assertInstanceOf(Exception::class, $e);
			$this->assertInstanceOf(ExceptionPath::class, $e);
		}
	}

	public function testSetMainTemplatePathAbsolute ()
	{
		$oMap = new ControllerMapT_underTest_setMainTemplatePath (FrontControllerFixture::class, '\A.*\Z');

		$this->assertTrue($oMap->setMainTemplatePath ( VSC_MOCK_PATH . 'templates/' ));
		$this->assertEquals(VSC_MOCK_PATH . 'templates/', $oMap->getMainTemplatePath());
	}

	public function testSetMainTemplatePathRelativeToWithModule ()
	{
		$oModuleMap = new ModuleMap(VSC_MOCK_PATH . 'config/map.php', '\A.*\Z');

		$oMap = new ControllerMapT_underTest_setMainTemplatePath(FrontControllerFixture::class, '\A.*\Z');
		$oMap->setModuleMap($oModuleMap);

		$this->assertTrue($oMap->setMainTemplatePath ( 'templates/' ));
		$this->assertEquals(VSC_MOCK_PATH . 'templates/', $oMap->getMainTemplatePath());
	}
}

class ControllerMapT_underTest_setMainTemplatePath extends MappingA {
	use ControllerMapTrait;
}
