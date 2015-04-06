<?php
namespace tests\res\infrastructure\Base;
use vsc\infrastructure\Base;

/**
 * @covers \vsc\infrastructure\Null::__call()
 */
class __call extends \PHPUnit_Framework_TestCase
{
	public function test__call ()
	{
		$null = new Base();

		$this->assertInstanceOf(Base::class, $null->__call ( 'getSomething', array()));
		$this->assertInstanceOf(Base::class, $null->getSomething('test'));
	}

}
