<?php
namespace tests\lib\presentation\responses\ExceptionResponseRedirect;
use vsc\presentation\responses\ExceptionResponseRedirect;
use vsc\presentation\responses\HttpResponseType;

/**
 * @covers \vsc\presentation\responses\ExceptionResponseRedirect::__construct()
 */
class __construct extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$sLocation = 'http://localhost/';
		$iStatus = HttpResponseType::CLIENT_ERROR;

		$o = new ExceptionResponseRedirect($sLocation, $iStatus);
		$this->assertEquals($sLocation, $o->getLocation());
		$this->assertEquals($iStatus, $o->getRedirectCode());
	}
}
