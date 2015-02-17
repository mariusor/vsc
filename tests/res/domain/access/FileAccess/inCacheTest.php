<?php
namespace tests\res\domain\access\FileAccess;
use vsc\domain\access\FileAccess;

/**
 * @covers \vsc\domain\access\FileAccess::inCache()
 */
class inCache extends \PHPUnit_Framework_TestCase
{
	public function testNotInCacheAtInitialization()
	{
		$o = new FileAccess(__FILE__);
		$this->assertFalse($o->inCache(__FILE__));
	}
}
