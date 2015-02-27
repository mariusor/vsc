<?php
namespace res\infrastructure\String;

use vsc\infrastructure\String;

/**
 * Class formatUriTest
 * @package res\infrastructure\String
 * @covers \vsc\infrastructure\String::formatUri()
 */
class formatUriTest extends \PHPUnit_Framework_TestCase {

	public function testReplaceSpaces () {
		$spacefilled = 'a n a a r e m e r e';
		$this->assertEquals(str_replace(' ', '+', $spacefilled), String::formatUri($spacefilled));
	}

	public function testReplaceAmpersands () {
		$test = 'ana&gigel';
		$this->assertEquals(str_replace('&', '&amp;', $test), String::formatUri($test));
	}
}
