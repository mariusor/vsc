<?php
namespace tests\lib\application\sitemaps\MappingA;
use mocks\application\sitemaps\MapFixture;

/**
 * @covers \vsc\application\sitemaps\MappingA::__construct()
 */
class __construct extends \BaseUnitTest
{
	public function testBasic__construct()
	{
		$sRegex = '.*';
		$sPath = __FILE__;
		$o = new MappingA_underTest___construct($sPath, $sRegex);
		$this->assertEquals($sPath, $o->getPath());
		$this->assertEquals($sRegex, $o->getRegex());
	}
}

class MappingA_underTest___construct extends MapFixture {}
