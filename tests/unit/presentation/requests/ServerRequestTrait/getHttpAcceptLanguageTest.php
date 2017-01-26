<?php
namespace tests\presentation\requests\ServerRequestTrait;
use vsc\presentation\requests\AuthenticatedRequestTrait;
use vsc\presentation\requests\ServerRequestTrait;

/**
 * @covers \vsc\presentation\requests\ServerRequestTrait::getHttpAcceptLanguage()
 */
class getHttpAcceptLanguage extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new ServerRequest_underTest_getHttpAcceptLanguage();
		$this->assertEquals([], $o->getHttpAcceptLanguage());
	}
}

class ServerRequest_underTest_getHttpAcceptLanguage {
	use ServerRequestTrait;
	use AuthenticatedRequestTrait;
}
