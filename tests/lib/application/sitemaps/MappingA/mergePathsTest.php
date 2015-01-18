<?php
namespace tests\lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ProcessorMap;

/**
 * @covers \vsc\application\sitemaps\MappingA::mergePaths()
 */
class mergePaths extends \PHPUnit_Framework_TestCase
{
	public function testBasicMergePaths()
	{
		$o = new MappingA_underTest_mergePaths();

		$oMap = new ProcessorMap(__FILE__, '.*');
		$o->mergePaths($oMap);

		$genericTemplatePath = VSC_RES_PATH . 'templates' . DIRECTORY_SEPARATOR;

		$this->assertEquals($oMap->getPath(), $o->getPath());
		$this->assertEquals($genericTemplatePath, $o->getTemplatePath());
		$this->assertEquals('', $o->getTemplate());
	}
}

class MappingA_underTest_mergePaths extends MappingA {
	public function __construct ($sPath = null, $sRegex = null) {
		if (is_null($sPath)) {
			$sPath = __FILE__;
		}
		if (is_null($sRegex)) {
			$sRegex = '.*';
		}
		parent::__construct($sPath, $sRegex);
	}

	public function mergePaths ($oMap) {
		return parent::mergePaths($oMap);
	}
}
