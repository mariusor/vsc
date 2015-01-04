<?php
namespace tests\lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseType;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::getHttpStatusString()
 */
class getHttpStatusString extends \PHPUnit_Framework_TestCase
{
	public function testGetHttpStatusString ()
	{
		$sProtocol = 'HTTP/1.1';
		$iStatus = HttpResponseType::ACCEPTED;
		$FullStatus = $sProtocol . ' ' . HttpResponseType::getStatus($iStatus);
		$this->assertEquals($FullStatus,  HttpResponseA_underTest_getHttpStatusString::getHttpStatusString($sProtocol, $iStatus));
	}
}

class HttpResponseA_underTest_getHttpStatusString extends HttpResponseA {}
