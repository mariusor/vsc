<?php
namespace tests\lib\ExceptionPath;

/**
 * @covers \vsc\ExceptionPath::getPath()
 */
class getPath extends \PHPUnit_Framework_TestCase
{
	public function testValidPath()
	{
		$E = new \vsc\ExceptionPath();
		$this->assertEquals(get_include_path(), $E->getPath());
	}
}
