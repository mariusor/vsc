<?php
namespace res\infrastructure\StringUtils;

use vsc\infrastructure\StringUtils;

/**
 * Class baseEncodeTest
 * @package res\infrastructure\StringUtils
 * @covers \vsc\infrastructure\StringUtils::baseEncode()
 */
class baseEncodeTest extends \BaseUnitTest {
	public function testBaseDecode () {
		$test1 = 1;
		$test2 = 2;

		$this->assertEquals($test1, StringUtils::baseEncode($test1));
		$this->assertEquals($test2, StringUtils::baseEncode($test2));
	}
}
