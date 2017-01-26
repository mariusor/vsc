<?php
namespace tests\functions_inc;

class cleanBuffers extends \BaseUnitTest
{
	public function testBasicCleanBuffers()
	{
		$s = ob_end_clean(); // phpunit buffer
		$output = 'asd';
		ob_start();
		$this->assertEquals(1, ob_get_level());
		echo $output;
		$errors = \vsc\cleanBuffers();
		$this->assertEquals(0, ob_get_level());

		$this->assertEquals(0, count($errors));
		ob_start(); // phpunit's buffer
	}
}
