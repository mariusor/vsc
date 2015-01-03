<?php
namespace tests\lib\ExceptionPath;

/**
 * @covers \vsc\ExceptionPath::getPathAsArray()
 */
class getPathAsArray extends \PHPUnit_Framework_TestCase
{
	public function testValidIncludePath()
	{
		$path = get_include_path();
		$array = explode(PATH_SEPARATOR, $path);

		$E = new \vsc\ExceptionPath();

		$this->assertEquals($array, $E->getPathAsArray());
	}
}
