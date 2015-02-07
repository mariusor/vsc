<?php
namespace tests\res\domain\access\FileAccess;
use vsc\domain\access\FileAccess;

/**
 * @covers \vsc\domain\access\FileAccess::setCachePath()
 */
class setCachePath extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$o = new FileAccess(__FILE__);
		$o->setCachePath(VSC_FIXTURE_PATH);
		$this->assertEquals(VSC_FIXTURE_PATH, $o->getCachePath());
	}
}
