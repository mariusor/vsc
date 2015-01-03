<?php
namespace tests\res\infrastructure\Null;
use vsc\infrastructure\Null;

/**
 * @covers \vsc\infrastructure\Null::__get()
 */
class __get extends \PHPUnit_Framework_TestCase
{
	public function test__get ()
	{
		$null = new Null();

		$this->assertInstanceOf(Null::class, $null->__get ('test'));
		$this->assertInstanceOf(Null::class, $null->test);
	}
}
