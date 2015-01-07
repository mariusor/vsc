<?php
namespace tests\lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\MappingA;

/**
 * @covers \vsc\application\sitemaps\MappingA::__construct()
 */
class __construct extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$sRegex = '.*';
		$sPath = __FILE__;
		$o = new MappingA_underTest___construct($sPath, $sRegex);
		$this->assertEquals($sPath, $o->getPath());
		$this->assertEquals($sRegex, $o->getRegex());
	}
}

class MappingA_underTest___construct extends MappingA {}
