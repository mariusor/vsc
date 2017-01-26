<?php
namespace tests\lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\ClassMap;
use vsc\application\sitemaps\ExceptionSitemap;
use vsc\application\sitemaps\ResourceMapTrait;

/**
 * @covers \vsc\application\sitemaps\ResourceMapTrait::mergeResources()
 */
class mergeResources extends \BaseUnitTest
{
	public function testBasicMergeResources()
	{
		$o = new ResourceMapTrait_underTest_mergeResources(self::class);

		$oMap = new ClassMap(self::class, '.*');
		$o->mergeResources($oMap);

		$this->assertEmpty($o->getResources());
	}
}

class ResourceMapTrait_underTest_mergeResources {
	use ResourceMapTrait { mergeResources as public;}

	/**
	 * @return string
	 * @throws ExceptionSitemap
	 */
	public function getModulePath() { }
}
