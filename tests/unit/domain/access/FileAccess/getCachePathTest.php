<?php
namespace tests\domain\access\FileAccess;
use vsc\domain\access\FileAccess;

/**
 * @covers \vsc\domain\access\FileAccess::getCachePath()
 */
class getCachePath extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new FileAccess(__FILE__);
		$this->assertNull($o->getCachePath());
	}
}
