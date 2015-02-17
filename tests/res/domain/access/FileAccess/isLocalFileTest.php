<?php
namespace tests\res\domain\access\FileAccess;
use vsc\domain\access\FileAccess;

/**
 * @covers \vsc\domain\access\FileAccess::isLocalFile()
 */
class isLocalFile extends \PHPUnit_Framework_TestCase
{
	public function testLocalFileIsLocal()
	{
		$o = new FileAccess(__FILE__);
		$this->assertTrue($o->isLocalFile());
	}
}
