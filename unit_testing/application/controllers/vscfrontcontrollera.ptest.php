<?php
import ('application');
import ('controllers');
import ('processors');
import ('sitemaps');
import ('presentation');
import ('responses');
import ('requests');

define ('BASE_PATH', dirname (__FILE__) . '/fixtures/');
import (BASE_PATH);

class vscFrontControllerATest extends PHPUnit_Framework_TestCase {
private $state;
	public function setUp () {
		$this->state = new vscGenericFrontController();

		$oMap = new vscControllerMap(__FILE__, '\A.*\Z');
		$this->state->setMap($oMap);
	}

	public function tearDown () {
		$this->state = null;
	}

	public function testGetResponse() {
		$oReq = new vscRwHttpRequest();
		return $this->assertInstanceOf('vscHttpResponseA', $this->state->getResponse($oReq));
	}
}
