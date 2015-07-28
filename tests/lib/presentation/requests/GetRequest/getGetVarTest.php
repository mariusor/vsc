<?php
namespace tests\lib\presentation\requests\GetRequest;
use fixtures\presentation\requests\PopulatedRequest;
use vsc\presentation\requests\GetRequest;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\GetRequest::getGetVar()
 */
class getGetVar extends \PHPUnit_Framework_TestCase
{
	public function tearDown() {
		@session_destroy();
	}

	public function testGetVar() {
		$o = new GetRequestT_underTest_getGetVar();
		$_GET = [
			'cucu' => 'pasare',
			'ana' => 'are',
			'mere' => '',
			'test' => 123
		];

		// GET var
		$this->assertEquals('pasare', $o->getVar('cucu')); // 'cucu' => 'pasare','ana' => 'are', 'mere' => '', 'test' => 123
		$this->assertEquals('are', $o->getVar('ana'));
		$this->assertEquals('', $o->getVar('mere'));
		$this->assertEquals(123, $o->getVar('test'));
	}
}

class GetRequestT_underTest_getGetVar {
	use GetRequest;

	public function __construct () {
		$this->initGet($_GET);
	}

	public function getVar ($key) {
		return $this->getGetVar($key);
	}
}
