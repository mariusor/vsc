<?php
namespace tests\lib\application\sitemaps\ProcessorMapT;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ProcessorMapT;
use vsc\presentation\responses\HttpResponseType;

/**
 * @covers \vsc\application\sitemaps\ProcessorMapT::setResponseStatus()
 */
class setResponseStatus extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$o = new ProcessorMapT_underTest_setResponseStatus();

		$o->setResponseStatus(HttpResponseType::CLIENT_ERROR);
		$this->assertEquals(HttpResponseType::CLIENT_ERROR, $o->getResponseStatus());

		$o->setResponseStatus(HttpResponseType::METHOD_NOT_ALLOWED);
		$this->assertEquals(HttpResponseType::METHOD_NOT_ALLOWED, $o->getResponseStatus());
	}
}

class ProcessorMapT_underTest_setResponseStatus extends MappingA {
	use ProcessorMapT;
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
