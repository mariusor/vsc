<?php
namespace tests\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::getDecodedVar()
 */
class getDecodedVar extends \BaseUnitTest
{
	public function providerForEmptyAtInitialize () {
		return [
			['!', '%21'],
			['*', '%2A'],
			["'", '%27'],
			['(', '%28'],
			[')', '%29'],
			[';', '%3B'],
			[':', '%3A'],
			['@', '%40'],
			['&', '%26'],
			['=', '%3D'],
			['+', '%2B'],
			['$', '%24'],
			[',', '%2C'],
			['/', '%2F'],
			['?', '%3F'],
			['%', '%25'],
			['#', '%23'],
			['[', '%5B'],
			[']', '%5D'],
			'empty' => ['', ''],
			'a' => ['a', 'a'],
			'space' => [' ', '%20'],
			'=' => ['=', '='],
			'arrays'=> [
				['test' => ' ', 'test2' => '@', 'test3' => '[', 'test4' => ']'],
				['test' => '%20', 'test2' => '%40', 'test3' => '%5B', 'test4' => '%5D']
			]
		];
	}

	/**
	 * @dataProvider providerForEmptyAtInitialize
	 * @param $expected
	 * @param $testValue
	 */
	public function testWithBasicData($expected, $testValue)
	{
		$this->assertEquals($expected, HttpRequestA_underTest_getDecodedVar::getDecodedVar($testValue));
	}
}

class HttpRequestA_underTest_getDecodedVar extends HttpRequestA {
	public static function getDecodedVar ($var) {
		return parent::getDecodedVar($var);
	}
}
