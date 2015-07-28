<?php
namespace lib\application\sitemaps\SiteMapA;

use vsc\application\sitemaps\SiteMapA;

/**
 * Class getAllModulesTest
 * @package lib\application\sitemaps\SiteMapA
 * @covers \vsc\application\sitemaps\SiteMapA::getAllModules()
 */
class getAllModulesTest extends \PHPUnit_Framework_TestCase
{
	public function testEmptyModulesAtInitialization() {
		$o = new SiteMapA_underTest_getAllModules();
		$this->assertEquals([], $o->getAllModules());
	}

	public function testBasicGetAllModules() {
		$o = new SiteMapA_underTest_getAllModules();
		$sRegex = '.*';
		$oModuleMap = $o->addModuleMap($sRegex, VSC_FIXTURE_PATH . 'config/map.php');

		$this->assertEquals([$sRegex => $oModuleMap], $o->getAllModules());
	}
}

class SiteMapA_underTest_getAllModules extends SiteMapA {
	public function getAllModules() {
		return parent::getAllModules();
	}
}
