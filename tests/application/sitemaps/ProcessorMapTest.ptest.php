<?php
use \vsc\application\sitemaps\ProcessorMap;
use \vsc\application\sitemaps\ModuleMap;

class ProcessorMapTest extends \PHPUnit_Framework_TestCase {
	public function setUp () {
		// @todo
	}

	public function tearDown () {
		// @todo
	}
	public function testSetTemplate () {
		$oMap = new ProcessorMap(VSC_FIXTURE_PATH . 'application/processors/ProcessorFixture.php', '\A.*\Z');;;

		$n = 'main.tpl.php';
		$oMap->setTemplate($n);


		$this->assertEquals($oMap->getTemplate(), $n);
	}

	public function testGetTemplatePath () {
		$oMap = new ProcessorMap(VSC_FIXTURE_PATH . 'application/processors/ProcessorFixture.php', '\A.*\Z');;

		$oMap->setTemplatePath(VSC_FIXTURE_PATH . 'templates/');
		$oMap->setTemplate('main.tpl.php');

		$this->assertEquals($oMap->getTemplatePath(), VSC_FIXTURE_PATH . 'templates/');
	}

	public function testSetTemplatePathRelativeNoModuleMap () {
		$oMap = new ProcessorMap(VSC_FIXTURE_PATH . 'application/processors/ProcessorFixture.php', '\A.*\Z');;;

		try {
			$oMap->setTemplatePath ( 'templates/' );
		} catch (\Exception $e) {
			// no module map for the relative path to work
			$this->assertInstanceOf('Exception', $e);
			$this->assertInstanceOf('\\vsc\\Exception', $e);
			$this->assertInstanceOf('\\vsc\\application\\sitemaps\\ExceptionSitemap', $e);
		}
	}

	public function testGetTemplatePathRelative () {
		$oModuleMap = new ModuleMap(VSC_FIXTURE_PATH . 'config/map.php', '\A.*\Z');

		$oMap = new ProcessorMap(VSC_FIXTURE_PATH . 'application/processors/ProcessorFixture.php', '\A.*\Z');;;
		$oMap->setModuleMap($oModuleMap);

		$oMap->setTemplatePath( 'templates/' );
		$oMap->setTemplate('main.tpl.php');

		$this->assertEquals($oMap->getTemplatePath(), VSC_FIXTURE_PATH . 'templates/');
	}
}
