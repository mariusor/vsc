<?php
namespace tests\lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\MappingA;

/**
 * @covers \vsc\application\sitemaps\MappingA::getTemplate()
 */
class getTemplate extends \PHPUnit_Framework_TestCase
{
	public function testDefaultValue ()
	{
		$o = new MappingA_underTest_getTemplate();
		$genericTemplatePath = VSC_RES_PATH . 'templates' . DIRECTORY_SEPARATOR;
		$this->assertEquals($genericTemplatePath, $o->getTemplatePath());
	}
}

class MappingA_underTest_getTemplate extends MappingA {
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
