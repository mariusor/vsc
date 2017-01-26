<?php
namespace tests\presentation\requests\ServerRequestTrait;
use vsc\presentation\requests\AuthenticatedRequestTrait;
use vsc\presentation\requests\ServerRequestTrait;

/**
 * @covers \vsc\presentation\requests\ServerRequestTrait::getHttpUserAgent()
 */
class getHttpUserAgent extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new ServerRequest_underTest_getHttpUserAgent();
		$this->assertEquals('', $o->getHttpUserAgent());
	}
}

class ServerRequest_underTest_getHttpUserAgent {
	use ServerRequestTrait;
	use AuthenticatedRequestTrait;
}
