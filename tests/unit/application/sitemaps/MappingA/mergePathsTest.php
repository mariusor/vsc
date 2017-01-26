<?php
namespace tests\application\sitemaps\MappingA;
use mocks\application\sitemaps\MapFixture;
use vsc\application\sitemaps\ClassMap;
use vsc\application\sitemaps\ContentTypeMappingInterface;

/**
 * @covers \vsc\application\sitemaps\MappingA::mergePaths()
 */
class mergePaths extends \BaseUnitTest
{
	public function testBasicMergePaths()
	{
		$o = new MappingA_underTest_mergePaths(self::class);

		$oMap = new ClassMap(self::class, '.*');
		$o->mergePaths($oMap);

		$this->assertEquals($oMap->getPath(), $o->getPath());
		$this->assertEquals('', $o->getTemplate());
		$this->assertNull($o->getTemplatePath());
	}

	public function testMergePathsForContentTypeMaps () {
		$o = new MappingA_underTest_mergePaths_ContentTypeInterface(self::class);
		$oMap = new ClassMap(self::class, '.*');
		$o->mergePaths($oMap);

		$this->assertEquals($oMap->getPath(), $o->getPath());
		$this->assertEquals('', $o->getTemplate());
		$this->assertNull($o->getTemplatePath());
	}
}

class MappingA_underTest_mergePaths extends MapFixture {
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

class MappingA_underTest_mergePaths_ContentTypeInterface extends MappingA_underTest_mergePaths implements ContentTypeMappingInterface {

	public function setMainTemplatePath($sPath)
	{
		// TODO: Implement setMainTemplatePath() method.
	}

	public function getMainTemplatePath()
	{
		// TODO: Implement getMainTemplatePath() method.
	}

	public function setMainTemplate($sPath)
	{
		// TODO: Implement setMainTemplate() method.
	}

	public function getMainTemplate()
	{
		// TODO: Implement getMainTemplate() method.
	}
}
