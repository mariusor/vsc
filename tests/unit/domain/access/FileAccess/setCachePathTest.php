<?php
namespace tests\domain\access\FileAccess;
use vsc\domain\access\FileAccess;

/**
 * @covers \vsc\domain\access\FileAccess::setCachePath()
 */
class setCachePath extends \BaseUnitTest
{
	public function testBasicSetCachePath()
	{
		$o = new FileAccess(__FILE__);
		$o->setCachePath(VSC_MOCK_PATH);
		$this->assertEquals(VSC_MOCK_PATH, $o->getCachePath());
	}
}
