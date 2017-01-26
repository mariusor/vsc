<?php
namespace res\infrastructure\StringUtils;

use vsc\infrastructure\StringUtils;

/**
 * Class _echoTest
 * @package res\infrastructure\StringUtils
 * @covers \vsc\infrastructure\StringUtils::_echo()
 */
class _echoTest extends \BaseUnitTest {

	public function testWTF() {
		$test = 'test';
		$times = 3;

		ob_start();
		StringUtils::_echo($test, $times);
		$output = ob_end_clean();
		$this->assertEquals(strlen($test) * $times, $output);
	}
}
