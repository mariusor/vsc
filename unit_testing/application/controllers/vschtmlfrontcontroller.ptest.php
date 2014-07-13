<?php
import (VSC_FIXTURE_PATH);

import ('application');
import ('controllers');
import ('processors');
import ('sitemaps');
import ('presentation');
import ('responses');
import ('requests');

class vscHtmlFrontControllerTest extends PHPUnit_Framework_TestCase  {
	private $state;
	public function setUp () {
		$this->state = new vscXhtmlController();

		$oMap = new vscControllerMap(__FILE__, '\A\Z');
		$this->state->setMap($oMap);
	}

	public function tearDown () {
		$this->state = null;
	}

	public function testGetResponse() {
		$this->markTestSkipped ('Need to finish this');
		$oReq = new vscRwHttpRequest();
		return $this->assertInstanceOf('vscHttpResponseA', $this->state->getResponse($oReq));
	}
}
