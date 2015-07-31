<?php
namespace tests\res\application\controllers\ContentTypeController;
use fixtures\presentation\views\testView;
use vsc\application\controllers\ContentTypeController;
use vsc\application\sitemaps\ClassMap;

/**
 * @covers \vsc\application\controllers\ContentTypeController::getView()
 */
class getView extends \PHPUnit_Framework_TestCase
{
	public function setUp () {
	}

	public function tearDown () {
	}

	public function testBasicGetView() {
		$state = new ContentTypeController_underTest_getView();

		$oMap = new ClassMap(self::class, '\A.*\Z');
		$oMap->setView(testView::class);

		$state->setMap($oMap);

		$this->assertNull($state->getView());
	}
}

class ContentTypeController_underTest_getView extends ContentTypeController {}
