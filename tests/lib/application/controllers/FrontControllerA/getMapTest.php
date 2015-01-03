<?php
namespace tests\lib\application\controllers\FrontControllerA;
use vsc\application\controllers\FrontControllerA;
use fixtures\presentation\views\testView;
use vsc\application\sitemaps\ControllerMap;
use fixtures\presentation\views\NullView;

/**
 * @covers \vsc\application\controllers\FrontControllerA::getMap()
 */
class getMap extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var FrontControllerA
	 */
	private $state;

	public function setUp () {

		$this->state = new FrontController_underTest_getMap();
		$oMap = new ControllerMap(__FILE__, '\A.*\Z');
		$oMap->setView(testView::class);

		$oMap->setMainTemplatePath(VSC_FIXTURE_PATH . 'templates');
		$oMap->setMainTemplate('main.tpl.php');

		$this->state->setMap($oMap);
	}

	public function tearDown () {
		$this->state = null;
	}

	public function testBasicGetMap() {
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
}

class FrontController_underTest_getMap extends FrontControllerA {
	public function getDefaultView() {
		return new NullView();
	}
}
