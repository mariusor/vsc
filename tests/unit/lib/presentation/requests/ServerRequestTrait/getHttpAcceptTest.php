<?php
namespace tests\lib\presentation\requests\ServerRequestTrait;
use vsc\presentation\requests\AuthenticatedRequestTrait;
use vsc\presentation\requests\ServerRequestTrait;

/**
 * @covers \vsc\presentation\requests\ServerRequestTrait::getHttpAccept()
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
	use ServerRequestTrait;
	use AuthenticatedRequestTrait;
}
