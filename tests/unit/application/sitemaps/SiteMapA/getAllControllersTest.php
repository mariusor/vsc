<?php
namespace lib\application\sitemaps\SiteMapA;

use mocks\application\controllers\FrontControllerFixture;
use vsc\application\sitemaps\SiteMapA;

/**
 * Class getAllControllersTest
 * @package lib\application\sitemaps\SiteMapA
 * @covers \vsc\application\sitemaps\SiteMapA::getAllControllers()
 */
class getAllControllersTest extends \BaseUnitTest
{
	public function testEmptyControllersAtInitialization() {
		$o = new SiteMapA_underTest_getAllControllers();
		$this->assertEquals([], $o->getAllControllers());
	}

	public function testBasicGetAllControllers() {
		$o = new SiteMapA_underTest_getAllControllers();
		$sRegex = '.*';
		$oMap = $o->map($sRegex, VSC_MOCK_PATH . 'config/map.php');
		$oCtrl = $oMap->map($sRegex, FrontControllerFixture::class);

		$this->assertEquals([$sRegex => $oCtrl], $o->getAllControllers());
	}
}

class SiteMapA_underTest_getAllControllers extends SiteMapA {
	public function getAllControllers() {
		return parent::getAllControllers();
	}
}
