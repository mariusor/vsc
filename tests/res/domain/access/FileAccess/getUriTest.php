<?php
namespace tests\res\domain\access\FileAccess;
use vsc\domain\access\FileAccess;

/**
 * @covers \vsc\domain\access\FileAccess::getUri()
 */
class getUri extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$o = new FileAccess(__FILE__);
		$this->assertEquals(__FILE__, $o->getUri());
	}
}
