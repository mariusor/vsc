<?php
namespace tests\res\infrastructure\Object;

/**
 * @covers \vsc\infrastructure\Object::__call()
 */
class __call extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
