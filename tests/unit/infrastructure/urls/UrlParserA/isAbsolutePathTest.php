<?php
namespace lib\infrastructure\urls\UrlParserA;
use vsc\infrastructure\urls\UrlParserA;

/**
 * Class isAbsolutePathTest
 * @package lib\infrastructure\urls\UrlParserA
 * @covers \vsc\infrastructure\urls\UrlParserA::isAbsolutePath()
 */
class isAbsolutePathTest extends \BaseUnitTest {

	public function testBasicIsAbsolutePath() {
		$test1 = '/';
		$test2 = uniqid('/');
		$test3 = uniqid('asd:');
		$test4 = 'ana/are/mere';

		$this->assertTrue(UrlParserA::isAbsolutePath($test1));
		$this->assertTrue(UrlParserA::isAbsolutePath($test2));
		$this->assertFalse(UrlParserA::isAbsolutePath($test3));
		$this->assertFalse(UrlParserA::isAbsolutePath($test4));
	}
}
