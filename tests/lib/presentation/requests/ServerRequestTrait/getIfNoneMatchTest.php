<?php
namespace tests\lib\presentation\requests\ServerRequestTrait;
use vsc\presentation\requests\AuthenticatedRequestTrait;
use vsc\presentation\requests\ServerRequestTrait;

/**
 * @covers \vsc\presentation\requests\ServerRequestTrait::getIfNoneMatch()
 */
class getIfNoneMatch extends \PHPUnit_Framework_TestCase
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
