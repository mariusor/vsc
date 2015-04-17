<?php
namespace tests\lib\ExceptionPath;
use vsc\ExceptionPath;

/**
 * @covers \vsc\ExceptionPath::getPathAsArray()
 */
class getPathAsArray extends \PHPUnit_Framework_TestCase
{
	public function testValidIncludePath()
	{
		$path = get_include_path();
		$array = explode(PATH_SEPARATOR, $path);

		$E = new ExceptionPath();

		$this->assertEquals($array, $E->getPathAsArray());
	}
}
