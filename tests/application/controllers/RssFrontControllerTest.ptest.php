<?php

use vsc\application\controllers\RssController;
use vsc\presentation\requests\RwHttpRequest;
use vsc\application\sitemaps\ControllerMap;
use vsc\presentation\responses\HttpResponseA;
use vsc\presentation\views\RssView;

class RssFrontControllerTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @var RssController
	 */
	private $state;

	public function setUp () {
		$this->state = new RssController();

		$oMap = new ControllerMap(__FILE__, '\A\Z');
		$this->state->setMap($oMap);
	}

	public function tearDown () {
		$this->state = null;
	}

	public function testGetResponse() {
		$oReq = new RwHttpRequest();
		$this->assertInstanceOf('\\vsc\\presentation\\responses\\HttpResponseA', $this->state->getResponse($oReq));
	}

	public function testGetDefaultView() {
		$v = $this->state->getDefaultView();
		$this->assertInstanceOf('\\vsc\\presentation\\views\\ViewA', $v);
		$this->assertInstanceOf('\\vsc\\presentation\\views\\RssView', $v);
	}
}
