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

use vsc\application\sitemaps\vscControllerMap;
use vsc\presentation\responses\vscHttpResponseA;
use vsc\application\controllers\vscFrontControllerA;
use _fixtures\application\controllers\vscGenericFrontController;
use _fixtures\presentation\requests\vscPopulatedRequest;
use _fixtures\application\processors\testFixtureProcessor;
use _fixtures\presentation\views\testView;

class vscFrontControllerATest extends \PHPUnit_Framework_TestCase {
	/**
	 * @var vscFrontControllerA
	 */
	private $state;
	private $controllerMapStub;
	public function setUp () {
		$this->state = new vscGenericFrontController();

		$oMap = new vscControllerMap(__FILE__, '\A.*\Z');
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
		$this->assertInstanceOf('vsc\\presentation\\views\\vscViewA', $v);
	}


	public function testGetView() {
		$v = $this->state->getView();

		$this->assertInstanceOf('vsc\\presentation\\views\\vscViewA', $v);
	}

	public function testSetGetView() {
		$v = $this->state->getView();

		$this->assertInstanceOf('vsc\\presentation\\views\\vscViewA', $v);
		$this->assertInstanceOf('_fixtures\\presentation\\views\\testView', $v);
	}

	public function testGetMap() {
		$m = $this->state->getMap();
		$this->assertInstanceOf('vsc\\application\\sitemaps\\vscMappingA', $m);
		$this->assertInstanceOf('vsc\\application\\sitemaps\\vscControllerMap', $m);
	}

	public function testSetGetMap() {
		$s = new vscControllerMap('application/controllers/vscGenericFrontcontroller.php', '\A.*\Z');
		$this->state->setMap($s);

		$m = $this->state->getMap();
		$this->assertInstanceOf('vsc\\application\\sitemaps\\vscMappingA', $m);
		$this->assertInstanceOf('vsc\\application\\sitemaps\\vscControllerMap', $m);
		$this->assertEquals($s, $m);
	}

	public function testGetResponse() {
		$r = new vscPopulatedRequest();
		$this->assertInstanceOf('vsc\\presentation\\responses\\vscHttpResponseA', $this->state->getResponse($r));
	}

	public function testGetResponseWithProcessor () {
		$r = new vscPopulatedRequest();
		$p = new testFixtureProcessor();

		$this->assertInstanceOf('vsc\\presentation\\responses\\vscHttpResponseA', $this->state->getResponse($r, $p));
	}



}
