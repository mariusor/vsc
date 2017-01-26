<?php
namespace tests\infrastructure\vsc;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\infrastructure\vsc::getIncludePaths()
 */
class getIncludePaths extends \BaseUnitTest
{
	public function testGetIncludePaths () {
		// =))
		$this->assertEquals(vsc::getIncludePaths(), explode (PATH_SEPARATOR, get_include_path()));
	}
}
