<?php
namespace tests\lib\presentation\responses\ExceptionResponseRedirect;
use vsc\presentation\responses\ExceptionResponseRedirect;
use vsc\presentation\responses\HttpResponseType;

/**
 * @covers \vsc\presentation\responses\ExceptionResponseRedirect::getRedirectCode()
 */
class getRedirectCode extends \PHPUnit_Framework_TestCase
{

	public function providerForTestBasicGetRedirectCode ()
	{
		$aStatuses = HttpResponseType::getList();
		$return = array();
		foreach ($aStatuses as $iStatus => $sStatus) {
			$return[] = [$iStatus];
		}
		return $return;
	}

	/**
	 * @dataProvider providerForTestBasicGetRedirectCode
	 */
	public function testBasicGetRedirectCode($iStatus)
	{
		$o = new ExceptionResponseRedirect_underTest_getRedirectCode($iStatus);
		$this->assertEquals($iStatus, $o->getRedirectCode());
	}
}

class ExceptionResponseRedirect_underTest_getRedirectCode extends ExceptionResponseRedirect {
	public function __construct ($iStatus, $sPath = 'http://localhost') {
		parent::__construct($sPath, $iStatus);
	}
}
