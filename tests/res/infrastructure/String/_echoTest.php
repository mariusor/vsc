<?php
namespace res\infrastructure\String;

use vsc\infrastructure\String;

/**
 * Class _echoTest
 * @package res\infrastructure\String
 * @covers \vsc\infrastructure\String::_echo()
 */
class _echoTest extends \PHPUnit_Framework_TestCase {

	public function testWTF() {
		$test = 'test';
		$times = 3;

		ob_start();
		String::_echo($test, $times);
		$output = ob_end_clean();
		$this->assertEquals(strlen($test) * $times, $output);
	}
}
