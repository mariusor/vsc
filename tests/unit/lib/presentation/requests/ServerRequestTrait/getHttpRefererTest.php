<?php
namespace tests\lib\presentation\requests\ServerRequestTrait;
use vsc\presentation\requests\AuthenticatedRequestTrait;
use vsc\presentation\requests\ServerRequestTrait;

/**
 * @covers \vsc\presentation\requests\ServerRequestTrait::getHttpReferer()
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
	use ServerRequestTrait;
	use AuthenticatedRequestTrait;
}
