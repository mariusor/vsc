<?php
namespace res\infrastructure\String;

use vsc\infrastructure\String;

/**
 * Class stripEntitiesTest
 * @package res\infrastructure\String
 * @covers \vsc\infrastructure\String::stripEntities()
 */
class stripEntitiesTest extends \PHPUnit_Framework_TestCase {

	public function testBasicStripEntities() {
		$test = 'test';
		$this->assertEquals(htmlentities($test), String::stripEntities($test));
	}
}
