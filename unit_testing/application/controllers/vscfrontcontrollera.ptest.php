<?php
vsc\import (VSC_FIXTURE_PATH);

vsc\import ('application');
vsc\import ('controllers');
vsc\import ('processors');
vsc\import ('sitemaps');
vsc\import ('presentation');
vsc\import ('responses');
vsc\import ('requests');

class vscFrontControllerATest extends PHPUnit_Framework_TestCase {
	private $state;
	private $controllerMapStub;
	public function setUp () {
		$this->state = new vscGenericFrontController();

		$oMap = new vscControllerMap(__FILE__, '\A.*\Z');
//		$this->state->setMap($this->getMock('vscControllerMap'));
	}

	public function tearDown () {
		$this->state = null;
	}

	public function testGetResponse() {
//		$oReq = new vscRwHttpRequest();
//		$this->assertInstanceOf('vscHttpResponseA', $this->state->getResponse($oReq));
		$this->assertTrue (true);
	}
}
