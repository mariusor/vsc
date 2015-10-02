<?php
namespace tests\lib\presentation\responses\ExceptionResponseRedirect;
use vsc\presentation\responses\HttpResponseType;
use vsc\presentation\responses\ExceptionResponseRedirect;

/**
 * @covers \vsc\presentation\responses\ExceptionResponseRedirect::getLocation()
 */
class getLocation extends \PHPUnit_Framework_TestCase
{
	public function testBasicGetLocation()
	{
		$sLocation = 'http://localhost';
		$iStatus = HttpResponseType::SEE_OTHER;

		$o = new ExceptionResponseRedirect($sLocation, $iStatus);
		$this->assertEquals($sLocation, $o->getLocation());
	}
}
