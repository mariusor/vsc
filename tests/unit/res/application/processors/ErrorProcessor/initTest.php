<?php
namespace tests\res\application\processors\ErrorProcessor;
use vsc\application\processors\ErrorProcessor;

/**
 * @covers \vsc\application\processors\ErrorProcessor::init()
 */
class init extends \PHPUnit_Framework_TestCase
{
	public function testUseless()
	{
		$e = new \Exception('asd');
		$o = new ErrorProcessor($e);
		$this->assertNull($o->init());
	}
}
