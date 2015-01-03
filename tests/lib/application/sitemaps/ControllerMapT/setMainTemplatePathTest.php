<?php
namespace tests\lib\application\sitemaps\ControllerMapT;
use vsc\application\sitemaps\ControllerMapT;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ModuleMap;

/**
 * @covers \vsc\application\sitemaps\ControllerMapT::setMainTemplatePath()
 */
class setMainTemplatePath extends \PHPUnit_Framework_TestCase
{
	public function testSetMainTemplatePathRelativeNoModuleMap ()
	{
		$oMap = new ControllerMapT_underTest_setMainTemplatePath (\fixtures\application\controllers\GenericFrontController::class, '\A.*\Z');

		try {
			$oMap->setMainTemplatePath ( 'templates/' );
		} catch (\Exception $e) {
			// no module map for the relative path to work
			$this->assertInstanceOf(\Exception::class, $e);
			$this->assertInstanceOf(\vsc\Exception::class, $e);
			$this->assertInstanceOf(\vsc\ExceptionPath::class, $e);
		}
	}

	public function testSetMainTemplatePathAbsolute ()
	{
		$oMap = new ControllerMapT_underTest_setMainTemplatePath (\fixtures\application\controllers\GenericFrontController::class, '\A.*\Z');

		$this->assertTrue($oMap->setMainTemplatePath ( VSC_FIXTURE_PATH . 'templates/' ));
		$this->assertEquals(VSC_FIXTURE_PATH . 'templates/', $oMap->getMainTemplatePath());
	}

	public function testSetMainTemplatePathRelativeToWithModule ()
	{
		$oModuleMap = new ModuleMap(VSC_FIXTURE_PATH . 'config/map.php', '\A.*\Z');

		$oMap = new ControllerMapT_underTest_setMainTemplatePath(\fixtures\application\controllers\GenericFrontController::class, '\A.*\Z');
		$oMap->setModuleMap($oModuleMap);

		$this->assertTrue($oMap->setMainTemplatePath ( 'templates/' ));
		$this->assertEquals(VSC_FIXTURE_PATH . 'templates/', $oMap->getMainTemplatePath());
	}
}

class ControllerMapT_underTest_setMainTemplatePath extends MappingA {
	use ControllerMapT;
}
