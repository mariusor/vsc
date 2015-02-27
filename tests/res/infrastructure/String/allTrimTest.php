<?php
namespace res\infrastructure\String;
use vsc\infrastructure\String;

/**
 * Class allTrimTest
 * @package res\infrastructure\String
 * @covers \vsc\infrastructure\String::allTrim()
 */
class allTrimTest extends \PHPUnit_Framework_TestCase {

	public function testBasicAllTrim() {
		$test = 'ana are mere';
		$spaces = sprintf(' %s ', $test);
		$tabs = sprintf("\t\t%s\t\t\t", $test);
		$newlines = sprintf("\n\n%s\r\n\r\r", $test);
		$mixed = sprintf("\n\t   \n \r  \t%s\r\n   \r\t\r", $test);

		$this->assertEquals($test, String::allTrim($spaces));
		$this->assertEquals($test, String::allTrim($tabs));
		$this->assertEquals($test, String::allTrim($newlines));
		$this->assertEquals($test, String::allTrim($mixed));
	}

}
