<?php
import (VSC_FIXTURE_PATH);

import ('application');
import ('controllers');
import ('processors');
import ('sitemaps');
import ('presentation');
import ('views');
import ('responses');
import ('requests');

class vscRssFrontControllerTest extends PHPUnit_Framework_TestCase {
	private $state;

	public function setUp () {
		$this->state = new vscRssController();

		$oMap = new vscControllerMap(__FILE__, '\A\Z');
		$this->state->setMap($oMap);
	}

	public function tearDown () {
		$this->state = null;
	}

	public function testGetResponse() {
		$oReq = new vscRwHttpRequest();
		$this->assertInstanceOf('vscHttpResponseA', $this->state->getResponse($oReq));
	}

	public function testGetDefaultView() {
		$v = $this->state->getDefaultView();
		$this->assertInstanceOf('vscViewA', $v);
		$this->assertInstanceOf('vscRssView', $v);
	}
}
