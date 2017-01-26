<?php
namespace tests\presentation\requests\FilesRequestTrait;
use vsc\presentation\requests\FilesRequestTrait;

/**
 * @covers \vsc\presentation\requests\FilesRequestTrait::getFiles()
 */
class getFiles extends \BaseUnitTest
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
	use FilesRequestTrait {initFiles as public;}
}
