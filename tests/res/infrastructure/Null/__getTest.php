<?php
namespace tests\res\infrastructure\Null;

/**
 * @covers \vsc\infrastructure\Null::__get()
 */
class __get extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
