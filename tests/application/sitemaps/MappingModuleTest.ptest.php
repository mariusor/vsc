<?php
use \vsc\application\sitemaps\ModuleMap;

class MappingModuleTest extends \PHPUnit_Framework_TestCase {
	public function setUp () {
		// @todo
	}

	public function tearDown () {
		// @todo
	}

	public function testSetTemplate () {
		$oMap = new ModuleMap(VSC_FIXTURE_PATH . 'config/map.php', '\A.*\Z');

		$n = 'main.tpl.php';
		$oMap->setTemplate($n);


		$this->assertEquals($oMap->getTemplate(), $n);
	}

	public function testGetMainTemplatePath () {
		$oMap = new ModuleMap(VSC_FIXTURE_PATH . 'config/map.php', '\A.*\Z');

		$oMap->setMainTemplatePath(VSC_FIXTURE_PATH . 'templates/');
		$oMap->setTemplate('main.tpl.php');

		$this->assertEquals($oMap->getMainTemplatePath(), VSC_FIXTURE_PATH . 'templates/');
	}

	public function testGetMainTemplatePathRelative () {
		$oMap = new ModuleMap(VSC_FIXTURE_PATH . 'config/map.php', '\A.*\Z');

		$oMap->setMainTemplatePath('templates/');
		$oMap->setTemplate('main.tpl.php');

		$this->assertEquals($oMap->getMainTemplatePath(), VSC_FIXTURE_PATH . 'templates/');
	}

	public function testGetTemplatePath () {
		$oMap = new ModuleMap(VSC_FIXTURE_PATH . 'config/map.php', '\A.*\Z');

		$oMap->setTemplatePath(VSC_FIXTURE_PATH . 'templates/');
		$oMap->setTemplate('main.tpl.php');

		$this->assertEquals($oMap->getTemplatePath(), VSC_FIXTURE_PATH . 'templates/');
	}

	public function testGetTemplatePathRelative () {
		$oMap = new ModuleMap(VSC_FIXTURE_PATH . 'config/map.php', '\A.*\Z');

		$oMap->setTemplatePath('templates/');
		$oMap->setTemplate('main.tpl.php');

		$this->assertEquals($oMap->getTemplatePath(), VSC_FIXTURE_PATH . 'templates/');
	}

	public function testGetModulePath () {
		$oMap = new ModuleMap(VSC_FIXTURE_PATH . 'config/map.php', '\A.*\Z');

		$oMap->setTemplatePath('templates/');
		$oMap->setTemplate('main.tpl.php');

		$this->assertEquals(VSC_FIXTURE_PATH, $oMap->getModulePath());
	}
}
