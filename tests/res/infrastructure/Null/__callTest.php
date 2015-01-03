<?php
namespace tests\res\infrastructure\Null;
use vsc\infrastructure\Null;

/**
 * @covers \vsc\infrastructure\Null::__call()
 */
class __call extends \PHPUnit_Framework_TestCase
{
	public function test__call ()
	{
		$null = new Null();

		$this->assertInstanceOf(Null::class, $null->__call ( 'getSomething', array()));
		$this->assertInstanceOf(Null::class, $null->getSomething('test'));
	}

}
