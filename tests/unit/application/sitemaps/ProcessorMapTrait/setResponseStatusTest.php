<?php
namespace tests\application\sitemaps\ProcessorMapTrait;
use mocks\application\sitemaps\MapFixture;
use vsc\application\sitemaps\ProcessorMapTrait;
use vsc\presentation\responses\HttpResponseType;

/**
 * @covers \vsc\application\sitemaps\ProcessorMapTrait::setResponseStatus()
 */
class setResponseStatus extends \BaseUnitTest
{
	public function testBasicSetResponseStatus()
	{
		$o = new ProcessorMapT_underTest_setResponseStatus();

		$o->setResponseStatus(HttpResponseType::CLIENT_ERROR);
		$this->assertEquals(HttpResponseType::CLIENT_ERROR, $o->getResponseStatus());

		$o->setResponseStatus(HttpResponseType::METHOD_NOT_ALLOWED);
		$this->assertEquals(HttpResponseType::METHOD_NOT_ALLOWED, $o->getResponseStatus());
	}
}

class ProcessorMapT_underTest_setResponseStatus extends MapFixture {
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
