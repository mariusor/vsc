<?php
namespace tests\res\application\processors\EmptyProcessor;
use vsc\application\processors\EmptyProcessor;

/**
 * @covers \vsc\application\processors\EmptyProcessor::init()
 */
class init extends \BaseUnitTest
{
	public function testUseless()
	{
		$o = new EmptyProcessor();
		$this->assertNull($o->init());
	}
}
