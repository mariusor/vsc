<?php
use \vsc\application\sitemaps\ControllerMap;
use \vsc\application\sitemaps\ModuleMap;

class ControllerMapTest extends \PHPUnit_Framework_TestCase {
	public function setUp () {
		// @todo
	}

	public function tearDown () {
		// @todo
	}

	public function testSetTemplate () {
		$oMap = new ControllerMap(VSC_FIXTURE_PATH . 'application/controllers/GenericFrontController.php', '\A.*\Z');

		$n = 'main.tpl.php';
		$oMap->setTemplate($n);

		$this->assertEquals($n, $oMap->getTemplate());
	}

	public function testGetTemplatePath () {
		$oMap = new ControllerMap(VSC_FIXTURE_PATH . 'application/controllers/GenericFrontController.php', '\A.*\Z');

		$oMap->setTemplatePath(VSC_FIXTURE_PATH . 'templates/');
		$oMap->setTemplate('main.tpl.php');

		$this->assertEquals(VSC_FIXTURE_PATH . 'templates/', $oMap->getTemplatePath());
	}

	public function testGetTemplatePathRelative () {
		$oModuleMap = new ModuleMap(VSC_FIXTURE_PATH . 'config/map.php', '\A.*\Z');

		$oMap = new ControllerMap(VSC_FIXTURE_PATH . 'application/controllers/GenericFrontController.php', '\A.*\Z');
		$oMap->setModuleMap($oModuleMap);

		$oMap->setTemplatePath ( 'templates/' );

		$this->assertEquals(VSC_FIXTURE_PATH . 'templates/', $oMap->getTemplatePath());
	}

	public function testGetMainTemplatePath () {
		$oMap = new ControllerMap(VSC_FIXTURE_PATH . 'application/controllers/GenericFrontController.php', '\A.*\Z');

		$oMap->setMainTemplatePath(VSC_FIXTURE_PATH . 'templates/');
		$oMap->setTemplate('main.tpl.php');

		$this->assertEquals(VSC_FIXTURE_PATH . 'templates/', $oMap->getMainTemplatePath());
	}

	public function testGetMainTemplatePathRelative () {
		$oModuleMap = new ModuleMap(VSC_FIXTURE_PATH . 'config/map.php', '\A.*\Z');

		$oMap = new ControllerMap(VSC_FIXTURE_PATH . 'application/controllers/GenericFrontController.php', '\A.*\Z');
		$oMap->setModuleMap($oModuleMap);

		$oMap->setMainTemplatePath ( 'templates/' );

		$this->assertEquals(VSC_FIXTURE_PATH . 'templates/', $oMap->getMainTemplatePath());
	}

	public function testSetMainTemplatePathRelativeNoModuleMap () {
		$oMap = new ControllerMap(VSC_FIXTURE_PATH . 'application/controllers/GenericFrontController.php', '\A.*\Z');

		try {
			$oMap->setTemplatePath ( 'templates/' );
		} catch (\Exception $e) {
			// no module map for the relative path to work
			$this->assertInstanceOf(\Exception::class, $e);
			$this->assertInstanceOf(\vsc\Exception::class, $e);
			$this->assertInstanceOf(\vsc\application\sitemaps\ExceptionSitemap::class, $e);
		}
	}
}
