<?php
vsc\import (VSC_FIXTURE_PATH);

vsc\import ('application');
vsc\import ('controllers');
vsc\import ('processors');
vsc\import ('sitemaps');
vsc\import ('presentation');
vsc\import ('responses');
vsc\import ('requests');
vsc\import ('views');

class vscFrontControllerATest extends PHPUnit_Framework_TestCase {
	/**
	 * @var vscFrontControllerA
	 */
	private $state;
	private $controllerMapStub;
	public function setUp () {
		$this->state = new vscGenericFrontController();

		$oMap = new vscControllerMap(__FILE__, '\A.*\Z');
		$oMap->setView(VSC_FIXTURE_PATH . 'presentation/views/testview.class.php');

		$oMap->setMainTemplatePath(VSC_FIXTURE_PATH . 'templates');
		$oMap->setMainTemplate('main.tpl.php');

		$this->state->setMap($oMap);
	}

	public function tearDown () {
		$this->state = null;
	}

	public function testGetDefaultView() {
		$v = $this->state->getDefaultView();
		$this->assertInstanceOf('vscViewA', $v);
	}


	public function testGetView() {
		$v = $this->state->getView();
		$this->assertInstanceOf('vscViewA', $v);
	}

	public function testSetGetView() {
		$v = $this->state->getView();

		$this->assertInstanceOf('vscViewA', $v);
		$this->assertInstanceOf('testView', $v);
	}

	public function testGetMap() {
		$m = $this->state->getMap();
		$this->assertInstanceOf('vscMappingA', $m);
		$this->assertInstanceOf('vscControllerMap', $m);
	}

	public function testSetGetMap() {
		$s = new vscControllerMap('\A.*\Z', VSC_FIXTURE_PATH . 'application/controllers/vscgenericfrontcontroller.class.php');
		$this->state->setMap($s);

		$m = $this->state->getMap();
		$this->assertInstanceOf('vscMappingA', $m);
		$this->assertInstanceOf('vscControllerMap', $m);
		$this->assertEquals($s, $m);
	}

	public function testGetResponse() {
		$r = new vscPopulatedRequest();
		$this->assertInstanceOf('vscHttpResponseA', $this->state->getResponse($r));
	}

	public function testGetResponseWithProcessor () {
		$r = new vscPopulatedRequest();
		$p = new testFixtureProcessor();

		$this->assertInstanceOf('vscHttpResponseA', $this->state->getResponse($r, $p));
	}



}
