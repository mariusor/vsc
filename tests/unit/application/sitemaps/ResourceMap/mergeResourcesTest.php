<?php
namespace tests\application\sitemaps\MappingA;
use vsc\application\sitemaps\ClassMap;
use vsc\application\sitemaps\ExceptionSitemap;
use vsc\application\sitemaps\ResourceMapInterface;
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

	public function testMergeJsFiles()
	{
		$sJs = VSC_MOCK_PATH . 'static' . DIRECTORY_SEPARATOR . 'fixture.js';
		$sJqueryUrl = '//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js';
		$res = [
			'scripts' => [
				0 => [
					$sJs,
					__FILE__,
				],
				1 => [
					$sJqueryUrl
				]
			]
		];
		$o = new ResourceMapTrait_underTest_mergeResources(self::class);
		$o->addScript($sJs);
		$o->addScript($sJqueryUrl, true);

		$oMap = new ClassMap(self::class, '.*');
		$oMap->addScript(__FILE__);

		$o->mergeResources($oMap);

		$testResources = $o->getResources();
		$this->assertArrayHasKey('scripts', $testResources);
		$this->assertEquals(2, count($testResources['scripts'][0]));
		$this->assertEquals(1, count($testResources['scripts'][1]));
		$this->assertEquals($res, $testResources);
	}

	public function testMergeCssFiles()
	{
		$sCss = VSC_MOCK_PATH . 'static' . DIRECTORY_SEPARATOR . 'fixture.css';
		$res = [
			'styles' => [
				'screen' => [
					$sCss,
					__FILE__,
				]
			]
		];
		$o = new ResourceMapTrait_underTest_mergeResources(self::class);
		$o->addStyle($sCss);

		$oMap = new ClassMap(self::class, '.*');
		$oMap->addStyle(__FILE__);

		$o->mergeResources($oMap);

		$testResources = $o->getResources();
		$this->assertArrayHasKey('styles', $testResources);
		$this->assertEquals(2, count($testResources['styles']['screen']));
		$this->assertEquals($res, $testResources);
	}

}

class ResourceMapTrait_underTest_mergeResources implements ResourceMapInterface {
	use ResourceMapTrait { mergeResources as public;}

	/**
	 * @return string
	 * @throws ExceptionSitemap
	 */
	public function getModulePath() { }
}
