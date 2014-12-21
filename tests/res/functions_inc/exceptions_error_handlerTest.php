<?php
namespace tests\res\functions_inc;

/**
 * @covers the  method functions_inc::exceptions_error_handler()
 */
class exceptions_error_handler extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
