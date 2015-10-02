<?php
namespace tests\lib\presentation\requests\ServerRequestTrait;
use vsc\presentation\requests\AuthenticatedRequestTrait;
use vsc\presentation\requests\ServerRequestTrait;

/**
 * @covers \vsc\presentation\requests\ServerRequestTrait::getHttpAcceptEncoding()
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
	use ServerRequestTrait;
	use AuthenticatedRequestTrait;
}
