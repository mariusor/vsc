<?php
/**
 * @author Marius Orcsik <marius@habarnam.ro>
 * @created 2015-07-28
 */
namespace lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::getCustomHeaders()
 */
class getCustomHeadersTest extends \BaseUnitTest
{
	public function testEmptyAtInitialization() {
		$o = new HttpResponseA_underTest_getCustomHeaders();
		$this->assertEquals([], $o->getCustomHeaders());
	}

	public function testAfterAddingSomeHeaders() {
		$o = new HttpResponseA_underTest_getCustomHeaders();
		$testHeaderName = 'example';
		$testHeaderValue = uniqid($testHeaderName . ':');
		$o->addHeader($testHeaderName, $testHeaderValue);
		$this->assertEquals([$testHeaderName => $testHeaderValue], $o->getCustomHeaders());
	}
}

class HttpResponseA_underTest_getCustomHeaders extends HttpResponseA {
	public function getCustomHeaders() {
		return parent::getCustomHeaders();
	}
}
