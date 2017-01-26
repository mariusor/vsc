<?php
namespace tests\lib\application\sitemaps\MappingA;
use mocks\application\sitemaps\MapFixture;
use vsc\application\sitemaps\ClassMap;
use vsc\application\sitemaps\ExceptionSitemap;
use vsc\application\sitemaps\ResourceMapTrait;

/**
 * @covers \vsc\application\sitemaps\MappingA::merge()
 */
class merge extends \BaseUnitTest
{
	public function testBasicMerge()
	{
		$o = new MappingA_underTest_merge (self::class);

		$oMap = new ClassMap(self::class, '.*');
		$o->merge ($oMap);

		$this->assertEmpty($o->getResources());
		$this->assertEquals($oMap->getPath(), $o->getPath());
		$this->assertEquals('', $o->getTemplate());
		$this->assertNull($o->getTemplatePath());
	}
}

class MappingA_underTest_merge extends MapFixture {
	use ResourceMapTrait;

	/**
	 * @return string
	 * @throws ExceptionSitemap
	 */
	public function getModulePath() {}
}
