<?php
namespace lib\application\sitemaps\SiteMapA;

use fixtures\application\controllers\GenericFrontController;
use vsc\application\sitemaps\SiteMapA;

/**
 * Class getAllControllersTest
 * @package lib\application\sitemaps\SiteMapA
 * @covers \vsc\application\sitemaps\SiteMapA::getAllControllers()
 */
class getAllControllersTest extends \PHPUnit_Framework_TestCase
{
	public function testEmptyModulesAtInitialization() {
		$o = new SiteMapA_underTest_getAllControllers();
		$this->assertEquals([], $o->getAllControllers());
	}

	public function testBasicGetAllModules() {
		$o = new SiteMapA_underTest_getAllControllers();
		$sRegex = '.*';
		$oMap = $o->map($sRegex, VSC_FIXTURE_PATH . 'config/map.php');
		$oCtrl = $oMap->map($sRegex, GenericFrontController::class);

		$this->assertEquals([$sRegex => $oCtrl], $o->getAllControllers());
	}
}

class SiteMapA_underTest_getAllControllers extends SiteMapA {
	public function getAllControllers() {
		return parent::getAllControllers();
	}
}
