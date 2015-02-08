<?php
namespace tests\res\infrastructure\vsc;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\infrastructure\vsc::name()
 */
class name extends \PHPUnit_Framework_TestCase
{
	public function testBasicName()
	{
		$this->assertEquals('VSC', strip_tags(vsc::name()));
	}
}
