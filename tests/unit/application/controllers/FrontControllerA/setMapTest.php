<?php
namespace tests\application\controllers\FrontControllerA;
use mocks\application\controllers\FrontControllerFixture;
use vsc\application\sitemaps\ClassMap;
use mocks\presentation\views\testView;
use mocks\presentation\views\NullView;
use vsc\application\controllers\FrontControllerA;
use vsc\application\sitemaps\MappingA;

/**
 * @covers \vsc\application\controllers\FrontControllerA::setMap()
 */
class setMap extends \BaseUnitTest
{
	/**
	 * @var FrontControllerA
	 */
	private $state;

	public function setUp () {

		$this->state = new FrontController_underTest_setMap();
		$oMap = new ClassMap(self::class, '\A.*\Z');
		$oMap->setView(testView::class);

		$oMap->setMainTemplatePath(VSC_MOCK_PATH . 'templates');
		$oMap->setMainTemplate('main.tpl.php');

		$this->state->setMap($oMap);
	}

	public function tearDown () {
		$this->state = null;
	}

	public function testSetGetMap() {
		$s = new ClassMap(FrontControllerFixture::class, '\A.*\Z');
		$this->state->setMap($s);

		$m = $this->state->getMap();
		$this->assertInstanceOf(MappingA::class, $m);
		$this->assertInstanceOf(ClassMap::class, $m);
		$this->assertEquals($s, $m);
	}
}

class FrontController_underTest_setMap extends FrontControllerA {
	public function getDefaultView() {
		return new NullView();
	}
}
