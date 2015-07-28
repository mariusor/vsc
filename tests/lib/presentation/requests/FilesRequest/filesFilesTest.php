<?php
namespace tests\lib\presentation\requests\FilesRequest;
use vsc\presentation\requests\FilesRequest;

/**
 * @covers \vsc\presentation\requests\FilesRequest::getFiles()
 */
class getFiles extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialize()
	{
		$_FILES = [];
		$o = new FilesRequest_underTest_getFiles();
		$o->initFiles($_FILES);
		$this->assertEquals($_FILES, $o->getFiles());
	}

	public function testInitializeWithMockedCookie()
	{
		$o = new FilesRequest_underTest_getFiles();
		$o->initFiles($_FILES);
		$this->assertEquals($_FILES, $o->getFiles());
	}
}

class FilesRequest_underTest_getFiles {
	use FilesRequest {initFiles as public;}
}
