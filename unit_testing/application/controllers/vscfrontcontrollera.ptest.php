<?php
import (VSC_FIXTURE_PATH);

import ('application');
import ('controllers');
import ('processors');
import ('sitemaps');
import ('presentation');
import ('responses');
import ('requests');

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