<?php
namespace lib\infrastructure\urls\UrlParserA;
use vsc\infrastructure\urls\UrlParserA;

/**
 * Class hasGoodTerminationTest
 * @package lib\infrastructure\urls\UrlParserA
 * @covers \vsc\infrastructure\urls\UrlParserA::hasGoodTermination()
 */
class hasGoodTerminationTest extends \BaseUnitTest {
	public function urlsProvider () {
		return [
			'root' => ['/', true],
			'rand#1' => [uniqid('test:') . '/', true],
			'rand#2' => [uniqid('test/') . '/', true],
			'rand#3' => [uniqid('test/') . '#', false],
			'query' => ['?ana=mere', false],
			'file' => ['.xml', true],
			'full_good' => ['http://example.com/index.xml', true],
			'full_bad' => ['http://example.com/index', false],
		];
	}

	/**
	 * @param string $url
	 * @param bool $status
	 * @dataProvider urlsProvider
	 */
	public function testBasicHasGoodTermination ($url, $status) {
		if ($status) {
			$this->assertTrue(UrlParserA::hasGoodTermination($url));
		} else {
			$this->assertFalse(UrlParserA::hasGoodTermination($url));
		}
	}
}
