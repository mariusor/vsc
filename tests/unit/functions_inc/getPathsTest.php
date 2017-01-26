<?php
namespace tests\functions_inc;

/**
 * Class getPaths
 * @package tests\res\functions_inc
 */
class getPaths extends \BaseUnitTest
{
	public function testBasicGetPaths()
	{
		$this->assertEquals(explode (PATH_SEPARATOR, get_include_path()), \vsc\getPaths());
	}
}
