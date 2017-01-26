<?php
namespace tests\domain\access\FileAccess;
use vsc\domain\access\FileAccess;

/**
 * @covers \vsc\domain\access\FileAccess::getUri()
 */
class getUri extends \BaseUnitTest
{
	public function testFilePathSameAsGetUri()
	{
		$o = new FileAccess(__FILE__);
		$this->assertEquals(__FILE__, $o->getUri());
	}
}
