<?php
namespace tests\res\domain\access\FileAccess;
use vsc\domain\access\FileAccess;

/**
 * @covers \vsc\domain\access\FileAccess::getLocalPath()
 */
class getLocalPath extends \PHPUnit_Framework_TestCase
{
	public function testEmpty()
	{
		$o = new FileAccess('');
		$this->assertEquals(DIRECTORY_SEPARATOR, $o->getLocalPath(''));
	}
}
