<?php
namespace res\application\sitemaps\ModuleMap;

use vsc\application\sitemaps\ModuleMap;

/**
 * Class __constructTest
 * @package res\application\sitemaps\ModuleMap
 * @covers \vsc\application\sitemaps\ModuleMap::__construct()
 */
class __constructTest extends \BaseUnitTest {

	public function testInitialization () {
		$r = '';
		$o = new ModuleMap(VSC_MOCK_PATH . 'config/map.php', $r);
		$this->assertEquals(VSC_MOCK_PATH, $o->getPath());
		$this->assertEquals($r, $o->getRegex());
		$this->assertNull($o->getTemplatePath());
	}
}
