<?php
namespace tests\res\infrastructure\vsc;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\infrastructure\vsc::d()
 */
class d extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$value = 'test';
		$_SERVER['PHP_SELF'] = 'phpunit';
		ob_start();
		$this->assertContains($value, vsc::d($value));
	}
}
