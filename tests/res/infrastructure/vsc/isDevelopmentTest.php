<?php
namespace tests\res\infrastructure\vsc;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\infrastructure\vsc::isDevelopment()
 */
class isDevelopment extends \PHPUnit_Framework_TestCase
{
	public function testBasicIsDevelopment()
	{
		vsc::setInstance(new vsc());
		$_SERVER['REMOTE_ADDR'] = '198.111.111.1';
		$this->assertTrue (vsc::getEnv()->isDevelopment());
	}
}
