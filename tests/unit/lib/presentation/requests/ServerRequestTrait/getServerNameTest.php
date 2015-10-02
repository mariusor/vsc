<?php
namespace tests\lib\presentation\requests\ServerRequestTrait;
use vsc\presentation\requests\AuthenticatedRequestTrait;
use vsc\presentation\requests\ServerRequestTrait;

/**
 * @covers \vsc\presentation\requests\ServerRequestTrait::getServerName()
 */
class getServerName extends \PHPUnit_Framework_TestCase
{
	public function testGetNullServerName()
	{
		$_SERVER['SERVER_NAME'] = null;
		$o = new ServerRequest_underTest_getServerName();
		$this->assertNull($o->getServerName());
	}
}

class ServerRequest_underTest_getServerName {
	use ServerRequestTrait;
	use AuthenticatedRequestTrait;
}
