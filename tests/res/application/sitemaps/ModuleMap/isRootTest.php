<?php
namespace res\application\sitemaps\ModuleMap;

use vsc\application\sitemaps\ModuleMap;

/**
 * Class isRootTest
 * @package res\application\sitemaps\ModuleMap
 * @covers \vsc\application\sitemaps\ModuleMap::isRoot()
 */
class isRootTest extends \PHPUnit_Framework_TestCase
{
	public function testFalseAtInitialization() {
		$o = new ModuleMap(VSC_FIXTURE_PATH . 'config/map.php', '');
		$this->assertFalse($o->isRoot());
	}

	public function testMatchesValueAfterSet() {
		$o = new ModuleMap(VSC_FIXTURE_PATH . 'config/map.php', '');

		$o->setIsRoot(true);
		$this->assertTrue($o->isRoot());
		$o->setIsRoot(false);
		$this->assertFalse($o->isRoot());
	}
}

