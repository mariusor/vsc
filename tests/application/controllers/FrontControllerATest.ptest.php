<?php

use vsc\presentation\responses\HttpResponseA;
use vsc\application\controllers\FrontControllerA;
use \vsc\application\sitemaps\ControllerMap;
use fixtures\application\controllers\GenericFrontController;
use fixtures\presentation\requests\PopulatedRequest;
use fixtures\application\processors\ProcessorFixture;
use fixtures\presentation\views\testView;

class FrontControllerATest extends \PHPUnit_Framework_TestCase {
	/**
	 * @var FrontControllerA
	 */
	private $state;

	public function setUp () {
		$this->state = new GenericFrontController();

		$oMap = new ControllerMap(__FILE__, '\A.*\Z');
		$oMap->setView(testView::class);

		$oMap->setMainTemplatePath(VSC_FIXTURE_PATH . 'templates');
		$oMap->setMainTemplate('main.tpl.php');

		$this->state->setMap($oMap);
	}

	public function tearDown () {
		$this->state = null;
	}

	public function testGetDefaultView() {
		$v = $this->state->getDefaultView();
		$this->assertInstanceOf(\vsc\presentation\views\ViewA::class, $v);
	}


	public function testGetView() {
		$v = $this->state->getView();

		$this->assertInstanceOf(\vsc\presentation\views\ViewA::class, $v);
	}

	public function testSetGetView() {
		$v = $this->state->getView();

		$this->assertInstanceOf(\vsc\presentation\views\ViewA::class, $v);
		$this->assertInstanceOf(testView::class, $v);
	}

	public function testGetMap() {
		$m = $this->state->getMap();
		$this->assertInstanceOf(\vsc\application\sitemaps\MappingA::class, $m);
		$this->assertInstanceOf(\vsc\application\sitemaps\ControllerMap::class, $m);
	}

	public function testSetGetMap() {
		$s = new ControllerMap(\fixtures\application\controllers\GenericFrontController::class, '\A.*\Z');
		$this->state->setMap($s);

		$m = $this->state->getMap();
		$this->assertInstanceOf(\vsc\application\sitemaps\MappingA::class, $m);
		$this->assertInstanceOf(\vsc\application\sitemaps\ControllerMap::class, $m);
		$this->assertEquals($s, $m);
	}

	public function testGetResponse() {
		$r = new PopulatedRequest();
		$this->assertInstanceOf(\vsc\presentation\responses\HttpResponseA::class, $this->state->getResponse($r));
	}

	public function testGetResponseWithProcessor () {
		$r = new PopulatedRequest();
		$p = new ProcessorFixture();

		$this->assertInstanceOf(\vsc\presentation\responses\HttpResponseA::class, $this->state->getResponse($r, $p));
	}



}
