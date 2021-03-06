<?php
namespace tests\presentation\requests\ServerRequestTrait;
use vsc\presentation\requests\AuthenticatedRequestTrait;
use vsc\presentation\requests\ServerRequestTrait;

/**
 * @covers \vsc\presentation\requests\ServerRequestTrait::getHttpAcceptEncoding()
 */
class getHttpAcceptEncoding extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new ServerRequest_underTest_getHttpAcceptEncoding();
		$this->assertEquals([], $o->getHttpAcceptEncoding());
	}
}

class ServerRequest_underTest_getHttpAcceptEncoding {
	use ServerRequestTrait;
	use AuthenticatedRequestTrait;
}
