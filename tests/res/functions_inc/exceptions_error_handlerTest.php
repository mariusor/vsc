<?php
namespace tests\res\functions_inc;

class exceptions_error_handler extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
