<?php
namespace tests\lib\presentation\requests\ServerRequestTrait;
use vsc\presentation\requests\AuthenticatedRequestTrait;
use vsc\presentation\requests\ServerRequestTrait;

/**
 * @covers \vsc\presentation\requests\ServerRequestTrait::getHttpAcceptLanguage()
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
	use ServerRequestTrait;
	use AuthenticatedRequestTrait;
}
