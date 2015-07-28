<?php
namespace tests\lib\presentation\requests\ServerRequest;
use vsc\presentation\requests\AuthenticatedRequest;
use vsc\presentation\requests\ServerRequest;

/**
 * @covers \vsc\presentation\requests\ServerRequest::getHttpReferer()
 */
class getHttpReferer extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new ServerRequest_underTest_getHttpReferer();
		$this->assertEquals('', $o->getHttpReferer());
	}
}

class ServerRequest_underTest_getHttpReferer {
	use ServerRequest;
	use AuthenticatedRequest;
}
