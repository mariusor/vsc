<?php
namespace tests\lib\presentation\requests\ServerRequest;
use vsc\presentation\requests\AuthenticatedRequestT;
use vsc\presentation\requests\ServerRequest;

/**
 * @covers \vsc\presentation\requests\ServerRequest::getHttpAcceptCharset()
 */
class getHttpAcceptCharset extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new ServerRequest_underTest_getHttpAcceptCharset();
		$this->assertEquals([], $o->getHttpAcceptCharset());
	}
}

class ServerRequest_underTest_getHttpAcceptCharset {
	use ServerRequest;
	use AuthenticatedRequestT;
}
