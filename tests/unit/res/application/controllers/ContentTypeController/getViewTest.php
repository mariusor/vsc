<?php
namespace tests\res\application\controllers\ContentTypeController;
use mocks\presentation\views\testView;
use vsc\application\controllers\ContentTypeController;
use vsc\application\sitemaps\ClassMap;

/**
 * @covers \vsc\application\controllers\ContentTypeController::getView()
 */
class getView extends \BaseUnitTest
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
