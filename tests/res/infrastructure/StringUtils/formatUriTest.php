<?php
namespace res\infrastructure\StringUtils;

use vsc\infrastructure\StringUtils;

/**
 * Class formatUriTest
 * @package res\infrastructure\StringUtils
 * @covers \vsc\infrastructure\StringUtils::formatUri()
 */
class formatUriTest extends \PHPUnit_Framework_TestCase {

	public function testReplaceSpaces () {
		$spacefilled = 'a n a a r e m e r e';
		$this->assertEquals(str_replace(' ', '+', $spacefilled), StringUtils::formatUri($spacefilled));
	}

	public function testReplaceAmpersands () {
		$test = 'ana&gigel';
		$this->assertEquals(str_replace('&', '&amp;', $test), StringUtils::formatUri($test));
	}
}
