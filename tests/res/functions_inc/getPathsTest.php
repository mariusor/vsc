<?php
namespace tests\res\functions_inc;

/**
 * Class getPaths
 * @package tests\res\functions_inc
 * @covers \vsc\getPaths
 */
class getPaths extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->assertEquals(explode (PATH_SEPARATOR, get_include_path()), \vsc\getPaths());
	}
}
