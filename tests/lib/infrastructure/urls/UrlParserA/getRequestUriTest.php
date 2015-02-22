<?php
namespace lib\infrastructure\urls\UrlParserA;
use vsc\infrastructure\urls\UrlParserA;

/**
 * Class getRequestUriTest
 * @package lib\infrastructure\urls\UrlParserA
 * @covers \vsc\infrastructure\urls\UrlParserA::getRequestUri()
 */
class getRequestUriTest extends \PHPUnit_Framework_TestCase {

	public function testEmptyWithoutRequest () {
		$_SERVER = [];
		$this->assertEquals('', UrlParserA::getRequestUri());
	}

	public function testEmptyWithConfigRequest () {
		$this->assertEquals('/test/ana:are/test:123/', UrlParserA::getRequestUri());
	}

	public function testEmptyWithCustomHttpsRequest () {
		$_SERVER = [
			'HTTPS' => 'on',
			'HTTP_HOST' => 'example.com',
			'REQUEST_URI' => '/test/123#ttt'
		];
		$uri = sprintf ('https://%s%s', $_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI']);
		$this->assertEquals($uri, UrlParserA::getRequestUri());
	}

	public function testEmptyWithCustomRequest () {
		$_SERVER = [
			'HTTP_HOST' => 'example.com',
			'REQUEST_URI' => '/test/' . uniqid()
		];
		$uri = sprintf ('http://%s%s', $_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI']);
		$this->assertEquals($uri, UrlParserA::getRequestUri());
	}
}
