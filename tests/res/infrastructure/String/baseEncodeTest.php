<?php
namespace res\infrastructure\String;

use vsc\infrastructure\String;

/**
 * Class baseEncodeTest
 * @package res\infrastructure\String
 * @covers \vsc\infrastructure\String::baseEncode()
 */
class baseEncodeTest extends \PHPUnit_Framework_TestCase {
	public function testBaseDecode () {
		$test1 = 1;
		$test2 = 2;

		$this->assertEquals($test1, String::baseEncode($test1));
		$this->assertEquals($test2, String::baseEncode($test2));
	}
}
