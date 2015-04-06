<?php
namespace res\infrastructure\StringUtils;
use vsc\infrastructure\StringUtils;

/**
 * Class truncateTest
 * @package res\infrastructure\StringUtils
 * @covers \vsc\infrastructure\String::truncate()
 */
class truncateTest extends \PHPUnit_Framework_TestCase {

	public function testBasicTruncate () {
		$string = 'test';

		$this->assertEquals('t...', StringUtils::truncate($string, 1));
		$this->assertEquals('te...', StringUtils::truncate($string, 2));
		$this->assertEquals('tes...', StringUtils::truncate($string, 3));
		$this->assertEquals('test', StringUtils::truncate($string, 4));
		$this->assertEquals('test', StringUtils::truncate($string, 5));
	}

}
