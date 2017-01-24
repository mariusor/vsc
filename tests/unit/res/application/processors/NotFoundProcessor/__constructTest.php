<?php
namespace tests\res\application\processors\NotFoundProcessor;
use vsc\application\processors\NotFoundProcessor;
use vsc\presentation\responses\ExceptionResponseError;
use vsc\application\sitemaps\ErrorProcessorMap;
use vsc\presentation\responses\HttpResponseType;

/**
 * @covers \vsc\application\processors\NotFoundProcessor::__construct()
 */
class __construct extends \BaseUnitTest
{
	public function testBasic__construct()
	{
		$o = new NotFoundProcessor();

		$this->assertInstanceOf(ErrorProcessorMap::class, $o->getMap());
		$this->assertEquals ('templates', basename($o->getMap()->getTemplatePath()));
		$this->assertEquals ('error.tpl.php', $o->getMap()->getTemplate());

		$oModel = $o->getModel();
		$this->assertInstanceOf(ExceptionResponseError::class, $oModel->getException());
		$this->assertEquals(HttpResponseType::NOT_FOUND, $oModel->getException()->getErrorCode());
	}
}
