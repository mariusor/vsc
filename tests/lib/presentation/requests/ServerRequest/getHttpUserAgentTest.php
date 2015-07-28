<?php
namespace tests\lib\presentation\requests\ServerRequest;
use vsc\presentation\requests\AuthenticatedRequestT;
use vsc\presentation\requests\ServerRequest;

/**
 * @covers \vsc\presentation\requests\ServerRequest::getHttpUserAgent()
 */
class getHttpUserAgent extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new ServerRequest_underTest_getHttpUserAgent();
		$this->assertEquals('', $o->getHttpUserAgent());
	}
}

class ServerRequest_underTest_getHttpUserAgent {
	use ServerRequest;
	use AuthenticatedRequestT;
}
