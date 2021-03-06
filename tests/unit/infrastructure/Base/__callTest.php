<?php
namespace tests\infrastructure\Base;
use vsc\infrastructure\Base;

/**
 * @covers \vsc\infrastructure\Base::__call()
 */
class __call extends \BaseUnitTest
{
	public function test__call ()
	{
		$null = new Base();

		$this->assertInstanceOf(Base::class, $null->__call ( 'getSomething', array()));
		$this->assertInstanceOf(Base::class, $null->getSomething('test'));
	}

}
