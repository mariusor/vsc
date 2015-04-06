<?php
namespace tests\res\infrastructure\Base;
use vsc\infrastructure\Base;

/**
 * @covers \vsc\infrastructure\Base::__get()
 */
class __get extends \PHPUnit_Framework_TestCase
{
	public function test__get ()
	{
		$null = new Base();

		$this->assertInstanceOf(Base::class, $null->__get ('test'));
		$this->assertInstanceOf(Base::class, $null->test);
	}
}
