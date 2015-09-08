<?php
namespace res\application\sitemaps\ModuleMap;

use vsc\application\sitemaps\ModuleMap;

/**
 * Class __constructTest
 * @package res\application\sitemaps\ModuleMap
 * @covers \vsc\application\sitemaps\ModuleMap::__construct()
 */
class __constructTest extends \PHPUnit_Framework_TestCase {

	public function testInitialization () {
		$r = '';
		$o = new ModuleMap(VSC_FIXTURE_PATH . 'config/map.php', $r);
		$this->assertEquals(VSC_FIXTURE_PATH, $o->getPath());
		$this->assertEquals($r, $o->getRegex());
		$this->assertNull($o->getTemplatePath());
	}
}
