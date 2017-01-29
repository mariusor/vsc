<?php
namespace tests\application\sitemaps\MappingA;
use mocks\application\sitemaps\MapFixture;
use vsc\application\sitemaps\ClassMap;
use vsc\application\sitemaps\ExceptionSitemap;
use vsc\application\sitemaps\ResourceMapInterface;
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

	public function testMergeResourcesFiles()
	{
		$sCss = VSC_MOCK_PATH . 'static' . DIRECTORY_SEPARATOR . 'fixture.css';
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
			],
			'styles' => [
				'screen' => [
					$sCss,
					__FILE__,
				]
			]
		];
		$o = new MappingA_underTest_merge(self::class);
		$o->addScript($sJs);
		$o->addStyle($sCss);
		$o->addStyle(__FILE__);

		$oMap = new ClassMap(self::class, '.*');
		$oMap->addScript(__FILE__);
		$oMap->addScript($sJqueryUrl, true);

		$o->merge($oMap);

		$testResources = $o->getResources();
		$this->assertArrayHasKey('scripts', $testResources);
		$this->assertEquals(2, count($testResources['scripts'][0]));
		$this->assertEquals(1, count($testResources['scripts'][1]));
		$this->assertArrayHasKey('styles', $testResources);
		$this->assertEquals(2, count($testResources['styles']['screen']));
		$this->assertEquals($res, $testResources);
		$this->assertEquals($oMap->getPath(), $o->getPath());
		$this->assertEquals('', $o->getTemplate());
		$this->assertNull($o->getTemplatePath());
	}
}

class MappingA_underTest_merge extends MapFixture implements ResourceMapInterface {
	use ResourceMapTrait;

	/**
	 * @return string
	 * @throws ExceptionSitemap
	 */
	public function getModulePath() {}
}
