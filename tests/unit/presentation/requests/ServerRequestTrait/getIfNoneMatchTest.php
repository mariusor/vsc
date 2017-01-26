<?php
namespace tests\presentation\requests\ServerRequestTrait;
use vsc\presentation\requests\AuthenticatedRequestTrait;
use vsc\presentation\requests\ServerRequestTrait;

/**
 * @covers \vsc\presentation\requests\ServerRequestTrait::getIfNoneMatch()
 */
class getIfNoneMatch extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new ServerRequest_underTest_getIfNoneMatch();
		$this->assertEquals('', $o->getIfNoneMatch());
	}
}

class ServerRequest_underTest_getIfNoneMatch {
	use ServerRequestTrait;
	use AuthenticatedRequestTrait;
}
