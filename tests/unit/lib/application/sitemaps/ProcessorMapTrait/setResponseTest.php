<?php
namespace tests\lib\application\sitemaps\ProcessorMapTrait;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ProcessorMapTrait;
use vsc\presentation\responses\HttpResponse;
use vsc\presentation\responses\HttpResponseType;

/**
 * @covers \vsc\application\sitemaps\ProcessorMapTrait::setResponse()
 */
class setResponse extends \PHPUnit_Framework_TestCase
{
	public function testBasicSetResponse ()
	{
		$o = new ProcessorMapT_underTest_setResponse();
		$o->setResponse(new HttpResponse());

		$this->assertInstanceOf(HttpResponse::class, $o->getResponse());
	}
}
class ProcessorMapT_underTest_setResponse extends MappingA {
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
