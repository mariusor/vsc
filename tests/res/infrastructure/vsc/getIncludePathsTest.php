<?php
namespace tests\res\infrastructure\vsc;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\infrastructure\vsc::getIncludePaths()
 */
class getIncludePaths extends \PHPUnit_Framework_TestCase
{
	public function testGetIncludePaths () {
		// =))
		$this->assertEquals(vsc::getIncludePaths(), explode (PATH_SEPARATOR, get_include_path()));
	}
}
