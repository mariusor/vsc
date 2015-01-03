<?php
use \vsc\application\sitemaps\ModuleMap;
use \vsc\application\sitemaps\ClassMap;

class ClassMapTest extends \PHPUnit_Framework_TestCase {
	public function setUp () {
		// @todo
	}

	public function tearDown () {
		// @todo
	}

	public function testSetTemplate () {
		$oMap = new ClassMap(\fixtures\application\controllers\GenericFrontController::class, '\A.*\Z');

		$n = 'main.tpl.php';
		$oMap->setTemplate($n);

		$this->assertEquals($n, $oMap->getTemplate());
	}

	public function testGetTemplatePath () {
		$oMap = new ClassMap(\fixtures\application\controllers\GenericFrontController::class, '\A.*\Z');

		$oMap->setTemplatePath(VSC_FIXTURE_PATH . 'templates/');
		$oMap->setTemplate('main.tpl.php');

		$this->assertEquals(VSC_FIXTURE_PATH . 'templates/', $oMap->getTemplatePath());
	}

	public function testGetTemplatePathRelative () {
		$oModuleMap = new ModuleMap(VSC_FIXTURE_PATH . 'config/map.php', '\A.*\Z');

		$oMap = new ClassMap(\fixtures\application\controllers\GenericFrontController::class, '\A.*\Z');
		$oMap->setModuleMap($oModuleMap);

		$oMap->setTemplatePath ( 'templates/' );

		$this->assertEquals(VSC_FIXTURE_PATH . 'templates/', $oMap->getTemplatePath());
	}

	public function testGetMainTemplatePath () {
		$oMap = new ClassMap(\fixtures\application\controllers\GenericFrontController::class, '\A.*\Z');

		$oMap->setMainTemplatePath(VSC_FIXTURE_PATH . 'templates/');
		$oMap->setTemplate('main.tpl.php');

		$this->assertEquals(VSC_FIXTURE_PATH . 'templates/', $oMap->getMainTemplatePath());
	}

	public function testGetMainTemplatePathRelative () {
		$oModuleMap = new ModuleMap(VSC_FIXTURE_PATH . 'config/map.php', '\A.*\Z');

		$oMap = new ClassMap(\fixtures\application\controllers\GenericFrontController::class, '\A.*\Z');
		$oMap->setModuleMap($oModuleMap);

		$oMap->setMainTemplatePath ( 'templates/' );

		$this->assertEquals(VSC_FIXTURE_PATH . 'templates/', $oMap->getMainTemplatePath());
	}

	public function testSetMainTemplatePathRelativeNoModuleMap () {
		$oMap = new ClassMap(\fixtures\application\controllers\GenericFrontController::class, '\A.*\Z');

		try {
			$oMap->setTemplatePath ( 'templates/' );
		} catch (\Exception $e) {
			// no module map for the relative path to work
			$this->assertInstanceOf(\Exception::class, $e);
			$this->assertInstanceOf(\vsc\Exception::class, $e);
			$this->assertInstanceOf(\vsc\application\sitemaps\ExceptionSitemap::class, $e);
		}
	}

	public function testSetTemplatePathRelativeNoModuleMap () {
		$oMap = new ClassMap(\fixtures\application\processors\ProcessorFixture::class, '\A.*\Z');

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
