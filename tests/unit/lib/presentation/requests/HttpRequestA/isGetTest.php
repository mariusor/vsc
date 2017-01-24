<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestTypes;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::isGet()
 */
class isGet extends \BaseUnitTest
{
	public function testIsGet () {
		$o = new HttpRequestA_underTest_isGet();

		$o->setHttpMethod(HttpRequestTypes::GET);
		$this->assertFalse ($o->isHead());
		$this->assertTrue ($o->isGet());
		$this->assertFalse ($o->isPost());
		$this->assertFalse ($o->isPut());
		$this->assertFalse ($o->isDelete());
	}
}

class HttpRequestA_underTest_isGet extends HttpRequestA {
	public function setHttpMethod ($HttpMethod) {
		$this->sHttpMethod = $HttpMethod;
	}
}
