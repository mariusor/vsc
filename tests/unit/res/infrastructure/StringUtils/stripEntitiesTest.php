<?php
namespace res\infrastructure\StringUtils;

use vsc\infrastructure\StringUtils;

/**
 * Class stripEntitiesTest
 * @package res\infrastructure\StringUtils
 * @covers \vsc\infrastructure\StringUtils::stripEntities()
 */
class stripEntitiesTest extends \PHPUnit_Framework_TestCase {

	public function testBasicStripEntities() {
		$test = 'test';
		$this->assertEquals(htmlentities($test), StringUtils::stripEntities($test));
	}
}
