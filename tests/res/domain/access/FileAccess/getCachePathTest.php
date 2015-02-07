<?php
namespace tests\res\domain\access\FileAccess;
use vsc\domain\access\FileAccess;

/**
 * @covers \vsc\domain\access\FileAccess::getCachePath()
 */
class getCachePath extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new FileAccess(__FILE__);
		$this->assertNull($o->getCachePath());
	}
}
