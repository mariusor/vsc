<?php
namespace tests\ExceptionPath;
use vsc\ExceptionPath;

/**
 * @covers \vsc\ExceptionPath::getPath()
 */
class getPath extends \BaseUnitTest
{
	public function testValidPath()
	{
		$E = new ExceptionPath();
		$this->assertEquals(get_include_path(), $E->getPath());
	}
}
