<?php
namespace tests\presentation\responses\ExceptionResponseRedirect;
use vsc\presentation\responses\ExceptionResponseRedirect;
use vsc\presentation\responses\HttpResponseType;

/**
 * @covers \vsc\presentation\responses\ExceptionResponseRedirect::__construct()
 */
class __construct extends \BaseUnitTest
{
	public function testBasicInitialization()
	{
		$sLocation = 'http://localhost/';
		$iStatus = HttpResponseType::CLIENT_ERROR;

		$o = new ExceptionResponseRedirect($sLocation, $iStatus);
		$this->assertEquals($sLocation, $o->getLocation());
		$this->assertEquals($iStatus, $o->getRedirectCode());
	}
}
