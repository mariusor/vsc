<?php
namespace lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseType;

/**
 * Class isRedirectTest
 * @package lib\presentation\responses\HttpResponseA
 * @covers \vsc\presentation\responses\HttpResponseA::isRedirect()
 */
class isRedirectTest extends \PHPUnit_Framework_TestCase
{
	public function providerForHttpStatuses ()
	{
		$aStatuses = HttpResponseType::getList();
		$return = array();
		foreach ($aStatuses as $iStatus => $sStatus) {
			$return[] = [$iStatus];
		}
		return $return;
	}

	/**
	 * @param int $status
	 * @throws \vsc\presentation\responses\ExceptionResponse
	 * @dataProvider providerForHttpStatuses
	 */
	public function testBasicisRedirect($status) {
		$o = new HttpResponseA_underTest_isRedirect();
		$o->setStatus($status);

		if ($status >= 300 && $status < 400) {
			$this->assertTrue($o->isRedirect());
		} else {
			$this->assertFalse($o->isRedirect());
		}
	}
}

class HttpResponseA_underTest_isRedirect extends HttpResponseA {}
