<?php
namespace tests\presentation\responses\ExceptionResponseRedirect;
use vsc\presentation\responses\HttpResponseType;
use vsc\presentation\responses\ExceptionResponseRedirect;

/**
 * @covers \vsc\presentation\responses\ExceptionResponseRedirect::getLocation()
 */
class getLocation extends \BaseUnitTest
{
	public function testBasicGetLocation()
	{
		$sLocation = 'http://localhost';
		$iStatus = HttpResponseType::SEE_OTHER;

		$o = new ExceptionResponseRedirect($sLocation, $iStatus);
		$this->assertEquals($sLocation, $o->getLocation());
	}
}
