<?php
namespace tests\lib\application\sitemaps\ProcessorMapT;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ProcessorMapT;
use vsc\presentation\helpers\ViewHelperA;

/**
 * @covers \vsc\application\sitemaps\ProcessorMapT::registerHelper()
 */
class registerHelper extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
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

class ProcessorMapT_underTest_registerHelper extends MappingA {
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
