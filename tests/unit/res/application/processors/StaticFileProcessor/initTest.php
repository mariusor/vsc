<?php
namespace tests\res\application\processors\StaticFileProcessor;
use vsc\application\processors\StaticFileProcessor;

/**
 * @covers \vsc\application\processors\StaticFileProcessor::init()
 */
class init extends \BaseUnitTest
{
	public function testUseless()
	{
		$o = new StaticFileProcessor();
		$this->assertNull($o->init());
	}
}
