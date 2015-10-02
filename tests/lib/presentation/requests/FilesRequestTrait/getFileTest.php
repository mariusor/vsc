<?php
namespace tests\lib\presentation\requests\FilesRequestTrait;
use vsc\presentation\requests\FilesRequestTrait;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\FilesRequestTrait::getFile()
 */
class getFile extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialize()
	{
		$o = new FilesRequest_underTest_getFile();
		$o->initFiles($_FILES);
		$this->assertEmpty($o->getFile('test'));
	}

}

class FilesRequest_underTest_getFile {
	use FilesRequestTrait {initFiles as public;}
}

