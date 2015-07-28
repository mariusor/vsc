<?php
namespace tests\lib\presentation\requests\ServerRequest;
use vsc\presentation\requests\AuthenticatedRequestT;
use vsc\presentation\requests\ServerRequest;

/**
 * @covers \vsc\presentation\requests\ServerRequest::getServerName()
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
	use ServerRequest;
	use AuthenticatedRequestT;
}
