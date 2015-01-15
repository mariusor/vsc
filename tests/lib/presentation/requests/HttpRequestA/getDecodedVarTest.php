<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::getDecodedVar()
 */
class getDecodedVar extends \PHPUnit_Framework_TestCase
{
	public function providerForEmptyAtInitialize () {
		return [
			'empty' => ['', ''],
			'a' => ['a', 'a'],
			'space' => [' ', '%20'],
			'=' => ['=', '='],
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
	static public function getDecodedVar ($var) {
		return parent::getDecodedVar($var);
	}
}
