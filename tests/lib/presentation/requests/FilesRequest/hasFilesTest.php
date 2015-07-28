<?php
namespace tests\lib\presentation\requests\FilesRequest;
use vsc\presentation\requests\FilesRequest;

/**
 * @covers \vsc\presentation\requests\FilesRequest::hasFiles()
 */
class hasFiles extends \PHPUnit_Framework_TestCase
{
	public function testDefaultIsFalse()
	{
		$o = new FilesRequest_underTest_hasFiles();
		$o->initFiles($_FILES);
		$this->assertFalse($o->hasFiles());
	}
}

class FilesRequest_underTest_hasFiles {
	use FilesRequest {initFiles as public;}
}
