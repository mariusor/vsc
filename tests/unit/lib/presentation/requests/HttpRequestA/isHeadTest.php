<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestTypes;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::isHead()
 */
class isHead extends \BaseUnitTest
{
	public function testIsHead () {
		$o = new HttpRequestA_underTest_isHead();

		$o->setHttpMethod(HttpRequestTypes::HEAD);
		$this->assertTrue ($o->isHead());
		$this->assertFalse ($o->isGet());
		$this->assertFalse ($o->isPost());
		$this->assertFalse ($o->isPut());
		$this->assertFalse ($o->isDelete());
	}
}

class HttpRequestA_underTest_isHead extends HttpRequestA {
	public function setHttpMethod ($HttpMethod) {
		$this->sHttpMethod = $HttpMethod;
	}
}
