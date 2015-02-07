<?php
namespace tests\res\domain\access\FileAccess;
use vsc\domain\access\FileAccess;

/**
 * @covers \vsc\domain\access\FileAccess::getFile()
 */
class getFile extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->assertEquals(file_get_contents(__FILE__), FileAccess::getFile(__FILE__));
	}
}
