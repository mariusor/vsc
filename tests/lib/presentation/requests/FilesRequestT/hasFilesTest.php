<?php
namespace tests\lib\presentation\requests\FilesRequestT;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\FilesRequestT::hasFiles()
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
