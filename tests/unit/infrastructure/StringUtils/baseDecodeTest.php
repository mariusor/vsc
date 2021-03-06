<?php
namespace res\infrastructure\StringUtils;

use vsc\infrastructure\StringUtils;

/**
 * Class baseDecodeTest
 * @package res\infrastructure\StringUtils
 * @covers \vsc\infrastructure\StringUtils::baseDecode()
 */
class baseDecodeTest extends \BaseUnitTest {
	public function testBaseDecode () {
		$test1 = 1;
		$test2 = 2;

		$this->assertEquals($test1, StringUtils::baseDecode($test1));
		$this->assertEquals($test2, StringUtils::baseDecode($test2));
	}
}
