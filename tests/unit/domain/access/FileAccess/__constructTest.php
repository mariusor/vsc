<?php
namespace tests\domain\access\FileAccess;
use vsc\domain\access\FileAccess;

/**
 * @covers \vsc\domain\access\FileAccess::__construct()
 */
class __construct extends \BaseUnitTest
{
	public function testBasicInitialization()
	{
		$o = new FileAccess(__FILE__);
		$this->assertEquals(__FILE__, $o->getUri());
	}
}
