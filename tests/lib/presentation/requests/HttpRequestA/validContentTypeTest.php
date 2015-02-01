<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::validContentType()
 */
class validContentType extends \PHPUnit_Framework_TestCase
{
	public function testUseless()
	{
		$this->assertTrue(HttpRequestA::validContentType('*/*'));
	}
}
