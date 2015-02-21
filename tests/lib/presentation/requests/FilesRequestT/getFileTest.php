<?php
namespace tests\lib\presentation\requests\FilesRequestT;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\FilesRequestT::getFile()
 */
class getFile extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialize()
	{
		$o = new HttpRequestA_underTest_getFile();
		$this->assertEmpty($o->getFile('test'));
	}

}

class HttpRequestA_underTest_getFile extends HttpRequestA {}
