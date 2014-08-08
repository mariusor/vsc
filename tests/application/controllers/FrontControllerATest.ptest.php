<?php
// \vsc\import (VSC_FIXTURE_PATH);

// \vsc\import ('application');
// \vsc\import ('controllers');
// \vsc\import ('processors');
// \vsc\import ('sitemaps');
// \vsc\import ('presentation');
// \vsc\import ('responses');
// \vsc\import ('requests');
// \vsc\import ('views');

use vsc\application\sitemaps\ControllerMap;
use vsc\presentation\responses\HttpResponseA;
use vsc\application\controllers\FrontControllerA;
use _fixtures\application\controllers\GenericFrontController;
use _fixtures\presentation\requests\PopulatedRequest;
use _fixtures\application\processors\testFixtureProcessor;
use _fixtures\presentation\views\testView;

class FrontControllerATest extends \PHPUnit_Framework_TestCase {
	/**
	 * @var FrontControllerA
	 */
	private $state;
	private $controllerMapStub;
	public function setUp () {
		$this->state = new GenericFrontController();

		$oMap = new ControllerMap(__FILE__, '\A.*\Z');
		$oMap->setView('_fixtures\\presentation\\views\\testView');

		$oMap->setMainTemplatePath(VSC_FIXTURE_PATH . 'templates');
		$oMap->setMainTemplate('main.tpl.php');

		$this->state->setMap($oMap);
	}

	public function tearDown () {
		$this->state = null;
	}

	public function testGetDefaultView() {
		$v = $this->state->getDefaultView();
		$this->assertInstanceOf('\\vsc\\presentation\\views\\ViewA', $v);
	}


	public function testGetView() {
		$v = $this->state->getView();

		$this->assertInstanceOf('\\vsc\\presentation\\views\\ViewA', $v);
	}

	public function testSetGetView() {
		$v = $this->state->getView();

		$this->assertInstanceOf('\\vsc\\presentation\\views\\ViewA', $v);
		$this->assertInstanceOf('_fixtures\\presentation\\views\\testView', $v);
	}

	public function testGetMap() {
		$m = $this->state->getMap();
		$this->assertInstanceOf('\\vsc\\application\\sitemaps\\MappingA', $m);
		$this->assertInstanceOf('\\vsc\\application\\sitemaps\\ControllerMap', $m);
	}

	public function testSetGetMap() {
		$s = new ControllerMap('application/controllers/vscGenericFrontcontroller.php', '\A.*\Z');
		$this->state->setMap($s);

		$m = $this->state->getMap();
		$this->assertInstanceOf('\\vsc\\application\\sitemaps\\MappingA', $m);
		$this->assertInstanceOf('\\vsc\\application\\sitemaps\\ControllerMap', $m);
		$this->assertEquals($s, $m);
	}

	public function testGetResponse() {
		$r = new PopulatedRequest();
		$this->assertInstanceOf('\\vsc\\presentation\\responses\\HttpResponseA', $this->state->getResponse($r));
	}

	public function testGetResponseWithProcessor () {
		$r = new PopulatedRequest();
		$p = new testFixtureProcessor();

		$this->assertInstanceOf('\\vsc\\presentation\\responses\\HttpResponseA', $this->state->getResponse($r, $p));
	}



}
