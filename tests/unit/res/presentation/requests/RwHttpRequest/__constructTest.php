<?php
namespace tests\res\presentation\requests\RwHttpRequest;
use vsc\presentation\requests\RwHttpRequest;

/**
 * @covers \vsc\presentation\requests\RwHttpRequest::__construct()
 */
class __construct extends \BaseUnitTest
{
	public function testBasic__construct()
	{
		$_SERVER = [];
		$o = new RwHttpRequest();
		$this->assertEmpty($o->getUri());
		$this->assertEmpty($o->getTaintedVars());
	}
}
