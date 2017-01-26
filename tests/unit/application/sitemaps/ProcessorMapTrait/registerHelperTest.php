<?php
namespace tests\application\sitemaps\ProcessorMapTrait;
use mocks\application\sitemaps\MapFixture;
use vsc\application\sitemaps\ProcessorMapTrait;
use vsc\presentation\helpers\ViewHelperA;

/**
 * @covers \vsc\application\sitemaps\ProcessorMapTrait::registerHelper()
 */
class registerHelper extends \BaseUnitTest
{
	public function testBasicRegisterHelper()
	{
		$o = new ProcessorMapT_underTest_registerHelper();

		$o->registerHelper(new ViewHelperA_underTest_registerHelper());

		$helpers = $o->getViewHelpers();
		$this->assertEquals(1, count($helpers));
		foreach ($helpers as $helper) {
			$this->assertInstanceOf(ViewHelperA::class, $helper);
		}
	}
}

class ViewHelperA_underTest_registerHelper extends ViewHelperA {}

class ProcessorMapT_underTest_registerHelper extends MapFixture {
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
