<?php
namespace tests\res\infrastructure\vsc;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\infrastructure\vsc::isDevelopment()
 */
class isDevelopment extends \BaseUnitTest
{
	public function testBasicIsDevelopment()
	{
		vsc::setInstance(new vsc());
		$_SERVER['REMOTE_ADDR'] = '198.111.111.1';
		$this->assertTrue (vsc::getEnv()->isDevelopment());
	}
}
