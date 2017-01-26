<?php
namespace tests\ExceptionPath;
use vsc\ExceptionPath;

/**
 * @covers \vsc\ExceptionPath::getPathAsArray()
 */
class getPathAsArray extends \BaseUnitTest
{
	public function testValidIncludePath()
	{
		$path = get_include_path();
		$array = explode(PATH_SEPARATOR, $path);

		$E = new ExceptionPath();

		$this->assertEquals($array, $E->getPathAsArray());
	}
}
