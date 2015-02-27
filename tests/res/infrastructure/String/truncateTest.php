<?php
namespace res\infrastructure\String;
use vsc\infrastructure\String;

/**
 * Class truncateTest
 * @package res\infrastructure\String
 * @covers \vsc\infrastructure\String::truncate()
 */
class truncateTest extends \PHPUnit_Framework_TestCase {

	public function testBasicTruncate () {
		$string = 'test';

		$this->assertEquals('t...', String::truncate($string, 1));
		$this->assertEquals('te...', String::truncate($string, 2));
		$this->assertEquals('tes...', String::truncate($string, 3));
		$this->assertEquals('test', String::truncate($string, 4));
		$this->assertEquals('test', String::truncate($string, 5));
	}

}
