<?php
namespace tests\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestTypes;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::isPost()
 */
class isPost extends \BaseUnitTest
{
	public function testIsPost () {
		$o = new HttpRequestA_underTest_isPost();

		$o->setHttpMethod(HttpRequestTypes::POST);
		$this->assertFalse ($o->isHead());
		$this->assertFalse ($o->isGet());
		$this->assertTrue ($o->isPost());
		$this->assertFalse ($o->isPut());
		$this->assertFalse ($o->isDelete());
	}
}

class HttpRequestA_underTest_isPost extends HttpRequestA {
	public function setHttpMethod ($HttpMethod) {
		$this->sHttpMethod = $HttpMethod;
	}
}
