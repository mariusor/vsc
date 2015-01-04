<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::hasContentType()
 */
class hasContentType extends \PHPUnit_Framework_TestCase
{
	public function testHasContentType () {
		$this->assertFalse(HttpRequestA::hasContentType());

		$_SERVER['CONTENT_TYPE'] = 'test/test';
		$this->assertTrue(HttpRequestA::hasContentType());
	}
}
