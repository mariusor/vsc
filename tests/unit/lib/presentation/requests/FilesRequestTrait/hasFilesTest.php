<?php
namespace tests\lib\presentation\requests\FilesRequestTrait;
use vsc\presentation\requests\FilesRequestTrait;

/**
 * @covers \vsc\presentation\requests\FilesRequestTrait::hasFiles()
 */
class hasFiles extends \BaseUnitTest
{
	public function testDefaultIsFalse()
	{
		$o = new FilesRequest_underTest_hasFiles();
		$o->initFiles($_FILES);
		$this->assertFalse($o->hasFiles());
	}
}

class FilesRequest_underTest_hasFiles {
	use FilesRequestTrait {initFiles as public;}
}
