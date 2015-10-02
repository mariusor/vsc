<?php
namespace res\infrastructure\StringUtils;
use vsc\infrastructure\StringUtils;

/**
 * Class allTrimTest
 * @package res\infrastructure\StringUtils
 * @covers \vsc\infrastructure\StringUtils::allTrim()
 */
class allTrimTest extends \PHPUnit_Framework_TestCase {

	public function testBasicAllTrim() {
		$test = 'ana are mere';
		$spaces = sprintf(' %s ', $test);
		$tabs = sprintf("\t\t%s\t\t\t", $test);
		$newlines = sprintf("\n\n%s\r\n\r\r", $test);
		$mixed = sprintf("\n\t   \n \r  \t%s\r\n   \r\t\r", $test);

		$this->assertEquals($test, StringUtils::allTrim($spaces));
		$this->assertEquals($test, StringUtils::allTrim($tabs));
		$this->assertEquals($test, StringUtils::allTrim($newlines));
		$this->assertEquals($test, StringUtils::allTrim($mixed));
	}

}
