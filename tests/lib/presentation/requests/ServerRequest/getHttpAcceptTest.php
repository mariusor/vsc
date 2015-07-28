<?php
namespace tests\lib\presentation\requests\ServerRequest;
use vsc\presentation\requests\AuthenticatedRequestT;
use vsc\presentation\requests\ServerRequest;

/**
 * @covers \vsc\presentation\requests\ServerRequest::getHttpAccept()
 */
class getHttpAccept extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$_SERVER['HTTP_ACCEPT'] = '';
		$o = new ServerRequest_underTest_getHttpAccept();
		$this->assertEquals([], $o->getHttpAccept());
	}
}

class ServerRequest_underTest_getHttpAccept {
	use ServerRequest;
	use AuthenticatedRequestT;
}
