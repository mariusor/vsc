<?php
namespace tests\lib\application\sitemaps\ProcessorMapTrait;
use mocks\application\sitemaps\MapFixture;
use vsc\application\sitemaps\ProcessorMapTrait;
use vsc\presentation\responses\HttpResponse;

/**
 * @covers \vsc\application\sitemaps\ProcessorMapTrait::setResponse()
 */
class setResponse extends \BaseUnitTest
{
	public function testBasicSetResponse ()
	{
		$o = new ProcessorMapT_underTest_setResponse();
		$o->setResponse(new HttpResponse());

		$this->assertInstanceOf(HttpResponse::class, $o->getResponse());
	}
}
class ProcessorMapT_underTest_setResponse extends MapFixture {
	use ProcessorMapTrait;
	public function __construct ($sPath = null, $sRegex = null) {
		if (is_null($sPath)) {
			$sPath = __FILE__;
		}
		if (is_null($sRegex)) {
			$sRegex = '.*';
		}
		parent::__construct($sPath, $sRegex);
	}
}
