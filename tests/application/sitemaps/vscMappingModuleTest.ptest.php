<?php
use \vsc\application\sitemaps\vscModuleMap;

class vscMappingModuleTest extends \PHPUnit_Framework_TestCase {
	public function setUp () {
		// @todo
	}

	public function tearDown () {
		// @todo
	}

	public function testSetTemplate () {
		$oMap = new vscModuleMap(__FILE__, '\A.*\Z');

		$n = 'main.tpl.php';
		$oMap->setTemplate($n);


		$this->assertEquals($oMap->getTemplate(), $n);
	}

	public function testGetMainTemplatePath () {
		$oMap = new vscModuleMap(__FILE__, '\A.*\Z');

		$oMap->setTemplatePath(VSC_FIXTURE_PATH . 'templates/');
		$oMap->setTemplate('main.tpl.php');


		$this->assertEquals($oMap->getTemplatePath(), VSC_FIXTURE_PATH . 'templates/');
	}
}
