<?php
namespace tests\lib\presentation\requests\FilesRequestT;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\FilesRequestT::getFiles()
 */
class getFiles extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialize()
	{
		$_FILES = [];
		$o = new HttpRequestA_underTest_getFiles();
		$this->assertEquals($_FILES, $o->getFiles());
	}

	public function testInitializeWithMockedCookie()
	{
		$o = new HttpRequestA_underTest_getFiles();
		$this->assertEquals($_FILES, $o->getFiles());
	}
}

class HttpRequestA_underTest_getFiles extends HttpRequestA {}
