<?php
namespace tests\res\domain\access\FileAccess;
use vsc\domain\access\FileAccess;

/**
 * @covers \vsc\domain\access\FileAccess::isLocalFile()
 */
class isLocalFile extends \BaseUnitTest
{
	public function testLocalFileIsLocal()
	{
		$o = new FileAccess(__FILE__);
		$this->assertTrue($o->isLocalFile());
	}
}
