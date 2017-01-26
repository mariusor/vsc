<?php
namespace tests\domain\access\FileAccess;
use vsc\domain\access\FileAccess;

/**
 * @covers \vsc\domain\access\FileAccess::getFile()
 */
class getFile extends \BaseUnitTest
{
	public function testBasicGetFile()
	{
		$this->assertEquals(file_get_contents(__FILE__), FileAccess::getFile(__FILE__));
	}
}
