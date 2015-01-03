<?php
namespace tests\lib\application\controllers\FrontControllerA;
use vsc\application\sitemaps\ControllerMap;
use fixtures\presentation\views\testView;
use fixtures\presentation\views\NullView;
use vsc\application\controllers\FrontControllerA;

/**
 * @covers \vsc\application\controllers\FrontControllerA::setMap()
 */
class setMap extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var FrontControllerA
	 */
	private $state;

	public function setUp () {

		$this->state = new FrontController_underTest_setMap();
		$oMap = new ControllerMap(__FILE__, '\A.*\Z');
		$oMap->setView(testView::class);

		$oMap->setMainTemplatePath(VSC_FIXTURE_PATH . 'templates');
		$oMap->setMainTemplate('main.tpl.php');

		$this->state->setMap($oMap);
	}

	public function tearDown () {
		$this->state = null;
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

class FrontController_underTest_setMap extends FrontControllerA {
	public function getDefaultView() {
		return new NullView();
	}
}
