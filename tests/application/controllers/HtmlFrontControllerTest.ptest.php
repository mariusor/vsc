<?php

use vsc\application\controllers\XhtmlController;
use vsc\application\sitemaps\ControllerMap;

use _fixtures\presentation\requests\PopulatedRequest;

class HtmlFrontControllerTest extends \PHPUnit_Framework_TestCase  {
	/**
	 * @var XhtmlController
	 */
	private $state;

	public function setUp () {
		$this->state = new XhtmlController();

		$oMap = new ControllerMap(__FILE__, '\A.*\Z');
		$this->state->setMap($oMap);
	}

	public function tearDown () {
		$this->state = null;
	}

	public function testGetResponse() {
		$oReq = new PopulatedRequest();
		$this->assertInstanceOf('\\vsc\\presentation\\responses\\HttpResponseA', $this->state->getResponse($oReq));
	}

	public function testGetDefaultView() {
		$v = $this->state->getDefaultView();
		$this->assertInstanceOf('\\vsc\\presentation\\views\\ViewA', $v);
		$this->assertInstanceOf('\\vsc\\presentation\\views\\XhtmlView', $v);
	}
}