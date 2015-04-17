<?php
namespace tests\lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ProcessorMap;

/**
 * @covers \vsc\application\sitemaps\MappingA::mergeResources()
 */
class mergeResources extends \PHPUnit_Framework_TestCase
{
	public function testBasicMergeResources()
	{
		$o = new MappingA_underTest_mergeResources();

		$oMap = new ProcessorMap(__FILE__, '.*');
		$o->mergeResources($oMap);

		$this->assertEmpty($o->getResources());
	}
}

class MappingA_underTest_mergeResources extends MappingA {
	public function __construct ($sPath = null, $sRegex = null) {
		if (is_null($sPath)) {
			$sPath = __FILE__;
		}
		if (is_null($sRegex)) {
			$sRegex = '.*';
		}
		parent::__construct($sPath, $sRegex);
	}

	public function mergeResources ($oMap) {
		parent::mergeResources($oMap);
	}
}
