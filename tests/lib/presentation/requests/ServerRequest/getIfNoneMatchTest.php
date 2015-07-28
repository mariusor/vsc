<?php
namespace tests\lib\presentation\requests\ServerRequest;
use vsc\presentation\requests\AuthenticatedRequest;
use vsc\presentation\requests\ServerRequest;

/**
 * @covers \vsc\presentation\requests\ServerRequest::getIfNoneMatch()
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
	use ServerRequest;
	use AuthenticatedRequest;
}
