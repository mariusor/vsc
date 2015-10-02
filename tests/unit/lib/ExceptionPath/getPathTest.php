<?php
namespace tests\lib\ExceptionPath;
use vsc\ExceptionPath;

/**
 * @covers \vsc\ExceptionPath::getPath()
 */
class getPath extends \PHPUnit_Framework_TestCase
{
	public function testValidPath()
	{
		$E = new ExceptionPath();
		$this->assertEquals(get_include_path(), $E->getPath());
	}
}
