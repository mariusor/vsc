<?php
namespace tests\lib\presentation\requests\ServerRequest;
use vsc\presentation\requests\AuthenticatedRequest;
use vsc\presentation\requests\ServerRequest;

/**
 * @covers \vsc\presentation\requests\ServerRequest::getHttpAcceptLanguage()
 */
class getHttpAcceptLanguage extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new ServerRequest_underTest_getHttpAcceptLanguage();
		$this->assertEquals([], $o->getHttpAcceptLanguage());
	}
}

class ServerRequest_underTest_getHttpAcceptLanguage {
	use ServerRequest;
	use AuthenticatedRequest;
}
