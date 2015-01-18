<?php
namespace tests\lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ProcessorMap;

/**
 * @covers \vsc\application\sitemaps\MappingA::merge()
 */
class merge extends \PHPUnit_Framework_TestCase
{
	public function testBasicMerge()
	{
		$o = new MappingA_underTest_merge ();

		$oMap = new ProcessorMap(__FILE__, '.*');
		$o->merge ($oMap);

		$genericTemplatePath = VSC_RES_PATH . 'templates' . DIRECTORY_SEPARATOR;

		$this->assertEmpty($o->getResources());
		$this->assertEquals($oMap->getPath(), $o->getPath());
		$this->assertEquals($genericTemplatePath, $o->getTemplatePath());
		$this->assertEquals('', $o->getTemplate());
	}
}

class MappingA_underTest_merge extends MappingA {
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
