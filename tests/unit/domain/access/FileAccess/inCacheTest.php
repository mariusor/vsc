<?php
namespace tests\domain\access\FileAccess;
use vsc\domain\access\FileAccess;

/**
 * @covers \vsc\domain\access\FileAccess::inCache()
 */
class inCache extends \BaseUnitTest
{
	public function testNotInCacheAtInitialization()
	{
		$o = new FileAccess(__FILE__);
		$this->assertFalse($o->inCache(__FILE__));
	}
}
