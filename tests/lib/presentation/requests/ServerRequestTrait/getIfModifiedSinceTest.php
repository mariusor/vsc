<?php
namespace tests\lib\presentation\requests\ServerRequestTrait;
use vsc\presentation\requests\AuthenticatedRequestTrait;
use vsc\presentation\requests\ServerRequestTrait;

/**
 * @covers \vsc\presentation\requests\ServerRequestTrait::getIfModifiedSince()
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
	use ServerRequestTrait;
	use AuthenticatedRequestTrait;
}
