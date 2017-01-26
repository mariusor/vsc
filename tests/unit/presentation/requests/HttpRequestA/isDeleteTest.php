<?php
namespace tests\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestTypes;
use mocks\presentation\requests\PopulatedRequest;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::isDelete()
 */
class isDelete extends \BaseUnitTest
{

	public function testIsDelete () {
		$o = new PopulatedRequest();

		$o->setHttpMethod(HttpRequestTypes::DELETE);
		$this->assertFalse ($o->isHead());
		$this->assertFalse ($o->isGet());
		$this->assertFalse ($o->isPost());
		$this->assertFalse ($o->isPut());
		$this->assertTrue ($o->isDelete());
	}
}

class HttpRequestA_underTest_isDelete extends HttpRequestA {
	public function setHttpMethod ($HttpMethod) {
		$this->sHttpMethod = $HttpMethod;
	}
}
