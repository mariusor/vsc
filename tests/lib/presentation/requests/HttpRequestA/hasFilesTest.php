<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::hasFiles()
 */
class hasFiles extends \PHPUnit_Framework_TestCase
{
	public function testDefaultIsFalse()
	{
		$o = new HttpRequestA_underTest_hasFiles();
		$this->assertFalse($o->hasFiles());
	}
}
class HttpRequestA_underTest_hasFiles extends HttpRequestA {}
