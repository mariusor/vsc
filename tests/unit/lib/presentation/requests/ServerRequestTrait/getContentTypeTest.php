<?php
namespace tests\lib\presentation\requests\ServerRequestTrait;
use vsc\presentation\requests\AuthenticatedRequestTrait;
use vsc\presentation\requests\ServerRequestTrait;

/**
 * @covers \vsc\presentation\requests\ServerRequestTrait::getContentType()
 */
class getContentType extends \BaseUnitTest
{
	public function testEmptyAtInitialize()
	{
		$_COOKIE = [];
		$o = new ServerRequest_underTest_getContentType();
		$this->assertEmpty($o->getContentType());
	}
}

class ServerRequest_underTest_getContentType {
	use ServerRequestTrait;
	use AuthenticatedRequestTrait;
}
