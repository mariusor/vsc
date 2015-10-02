<?php
namespace tests\lib\presentation\requests\GetRequestTrait;
use fixtures\presentation\requests\PopulatedRequest;
use vsc\presentation\requests\GetRequestTrait;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\GetRequestTrait::getGetVar()
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
	use GetRequestTrait;

	public function __construct () {
		$this->initGet($_GET);
	}

	public function getVar ($key) {
		return $this->getGetVar($key);
	}
}
