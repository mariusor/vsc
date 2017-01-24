<?php
namespace tests\lib\presentation\requests\ServerRequestTrait;
use vsc\presentation\requests\AuthenticatedRequestTrait;
use vsc\presentation\requests\ServerRequestTrait;

/**
 * @covers \vsc\presentation\requests\ServerRequestTrait::getHttpAcceptCharset()
 */
class getHttpAcceptCharset extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new ServerRequest_underTest_getHttpAcceptCharset();
		$this->assertEquals([], $o->getHttpAcceptCharset());
	}
}

class ServerRequest_underTest_getHttpAcceptCharset {
	use ServerRequestTrait;
	use AuthenticatedRequestTrait;
}
