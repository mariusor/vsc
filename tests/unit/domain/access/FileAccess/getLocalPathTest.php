<?php
namespace tests\domain\access\FileAccess;
use vsc\domain\access\FileAccess;

/**
 * @covers \vsc\domain\access\FileAccess::getLocalPath()
 */
class getLocalPath extends \BaseUnitTest
{
	public function testEmpty()
	{
		$o = new FileAccess('');
		$this->assertEquals(DIRECTORY_SEPARATOR, $o->getLocalPath(''));
	}
}
