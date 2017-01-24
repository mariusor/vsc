<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestTypes;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::isPut()
 */
class isPut extends \BaseUnitTest
{
	public function testIsPut () {
		$o = new HttpRequestA_underTest_isPut();

		$o->setHttpMethod(HttpRequestTypes::PUT);
		$this->assertFalse ($o->isHead());
		$this->assertFalse ($o->isGet());
		$this->assertFalse ($o->isPost());
		$this->assertTrue ($o->isPut());
		$this->assertFalse ($o->isDelete());
	}
}

class HttpRequestA_underTest_isPut extends HttpRequestA {
	public function setHttpMethod ($HttpMethod) {
		$this->sHttpMethod = $HttpMethod;
	}
}
