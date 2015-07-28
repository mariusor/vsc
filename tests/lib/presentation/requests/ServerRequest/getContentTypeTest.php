<?php
namespace tests\lib\presentation\requests\ServerRequest;
use vsc\presentation\requests\AuthenticatedRequest;
use vsc\presentation\requests\ServerRequest;

/**
 * @covers \vsc\presentation\requests\ServerRequest::getContentType()
 */
class getContentType extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialize()
	{
		$_COOKIE = [];
		$o = new ServerRequest_underTest_getContentType();
		$this->assertEmpty($o->getContentType());
	}
}

class ServerRequest_underTest_getContentType {
	use ServerRequest;
	use AuthenticatedRequest;
}
