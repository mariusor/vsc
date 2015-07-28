<?php
namespace tests\lib\presentation\requests\ServerRequest;
use vsc\presentation\requests\AuthenticatedRequest;
use vsc\presentation\requests\ServerRequest;

/**
 * @covers \vsc\presentation\requests\ServerRequest::getIfModifiedSince()
 */
class getIfModifiedSince extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new ServerRequest_underTest_getIfModifiedSince();
		$this->assertEquals('', $o->getIfModifiedSince());
	}
}

class ServerRequest_underTest_getIfModifiedSince {
	use ServerRequest;
	use AuthenticatedRequest;
}
