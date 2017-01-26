<?php
namespace tests\infrastructure\vsc;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\infrastructure\vsc::d()
 */
class d extends \BaseUnitTest
{
	public function testBasicDebugOutput()
	{
		$value = 'test';
		$_SERVER['PHP_SELF'] = 'phpunit';
		ob_start();
		$this->assertContains($value, vsc::d($value));
	}
}
