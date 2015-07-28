<?php
namespace tests\lib\presentation\requests\ServerRequest;
use vsc\presentation\requests\AuthenticatedRequestT;
use vsc\presentation\requests\ServerRequest;

/**
 * @covers \vsc\presentation\requests\ServerRequest::getHttpAcceptEncoding()
 */
class getHttpAcceptEncoding extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new ServerRequest_underTest_getHttpAcceptEncoding();
		$this->assertEquals([], $o->getHttpAcceptEncoding());
	}
}

class ServerRequest_underTest_getHttpAcceptEncoding {
	use ServerRequest;
	use AuthenticatedRequestT;
}
