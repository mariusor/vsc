<?php
/**
 * @author Marius Orcsik <marius.orcsik@rocket-internet.de>
 * @copyright Copyright (c) 2015 Rocket Internet SE, Johannisstraße 20, 10117 Berlin, http://www.rocket-internet.de
 * @created 2015-08-26
 */
namespace tests\lib\infrastructure\urls\UrlParserA;

use vsc\infrastructure\urls\UrlParserA;

/**
 * Class normalizePathTest
 * @package tests\lib\infrastructure\urls\UrlParserA
 * @covers vsc\infrastructure\urls\UrlParserA::normalizePath()
 */
class normalizePathTest extends \BaseUnitTest
{
	public function providerForNormalize() {
		return [
			// initial slash
			'basic root' => ['/', '/'],
			'duplicate slash' => ['/', '//'],
			'triplicate slash' => ['/', '///'],
			'current dir' => ['/', '/./'],
			'current dir no slash' => ['/', '/.'],
			'root parent dir' => ['/', '/../'], // this should probably trigger error as there is no parent
			'root parent dir no slash' => ['/', '/..'], // this should probably trigger error as there is no parent
			'parent dir' => ['/test/', '/test/ana/../'],
			'parent dir no slash at the end' => ['/test', '/test/ana/..'],
			'current dir' => ['/test/', '/test/./'],
			'current dir no slash at the end' => ['/test', '/test/.'],
			'double slash in path' => ['/test/ana/', '/test//ana/'],
			'driple slash in path' => ['/test/ana/', '/test///ana/'],
			'current dir in path' => ['/test/ana/', '/test/./ana/'],
			// no initial slash
			'empty' => ['', ''],
			'empty parent' => ['', '../'],
			'empty relative current dir' => ['', './'],
			'current dir' => ['ana/', 'ana/./'],
			'relative current dir' => ['ana/', './ana/./'],
			'current dir no slash' => ['ana', 'ana/.'],
			'relative current dir no slash' => ['ana', './ana/.'],
			'parent dir empty' => ['', 'test/..'],
			'relative parent dir empty' => ['', './test/..'],
			'parent dir empty ending slash' => ['', 'test/../'],
			'relative parent dir empty ending slash' => ['', './test/../'],
			'parent dir' => ['test', 'test/ana/..'],
			'relative with parent dir' => ['test', './test/ana/..'],
			'parent dir ending slash' => ['test/', 'test/ana/../'],
			'relative with parent dir ending slash' => ['test/', './test/ana/../'],
		];
	}

	/**
	 * @param $normalized
	 * @param $nonNormalized
	 * @dataProvider providerForNormalize
	 */
	public function testBasicNormalize ($normalized, $nonNormalized) {
		$this->assertEquals($normalized, UrlParserA::normalizePath($nonNormalized));
	}
}
