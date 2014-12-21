<?php

use vsc\application\controllers\XhtmlController;
use vsc\application\sitemaps\ControllerMap;
use fixtures\presentation\requests\PopulatedRequest;
use vsc\presentation\responses\HttpResponseA;

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
		$this->assertInstanceOf(\vsc\presentation\responses\HttpResponseA::class, $this->state->getResponse($oReq));
	}
}
