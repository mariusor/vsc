<?php
namespace tests\res\infrastructure\vsc;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\infrastructure\vsc::nl()
 */
class nl extends \BaseUnitTest
{
	public function testBasicNl()
	{
		vsc::setInstance(new vsc());
		$this->assertEquals("\n", vsc::nl());
	}
}
