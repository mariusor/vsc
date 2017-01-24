<?php
namespace tests\lib\application\sitemaps\MappingA;
use mocks\application\controllers\FrontControllerFixture;
use vsc\application\controllers\ExceptionController;
use vsc\application\sitemaps\ClassMap;
use vsc\application\sitemaps\MappingA;
use vsc\Exception;

/**
 * @covers \vsc\application\sitemaps\MappingA::map()
 */
class map extends \BaseUnitTest
{
	public function testMapClass()
	{
		$o = new MappingA_underTest_mapController();
		$oMap = $o->map ('.*', FrontControllerFixture::class);

		$this->assertInstanceOf(MappingA::class, $oMap);
		$this->assertInstanceOf(ClassMap::class, $oMap);
	}

	public function testMapFile()
	{
		$o = new MappingA_underTest_mapController();
		try {
			$o->map('.*', VSC_MOCK_PATH . 'application/controllers/FrontControllerFixture.php');
		} catch (\Exception $e) {
			$this->assertInstanceOf(Exception::class, $e);
			$this->assertInstanceOf(ExceptionController::class, $e);
		}
	}

	public function testBasicMapController ()
	{
		$regex = '.*';
		$o = new ClassMap(self::class, '.*');
		$map = $o->map($regex, self::class);

		$this->assertInstanceOf(MappingA::class, $map);
		$this->assertEquals($regex, $map->getRegex());
		$this->assertEquals(self::class, $map->getPath());
	}

	public function testMapControllerWithNoRegex ()
	{
		$o = new ClassMap(self::class, '.*');
		$map = $o->map(self::class);

		$this->assertInstanceOf(MappingA::class, $map);
		$this->assertEquals($o->getRegex(), $map->getRegex());
		$this->assertEquals(self::class, $map->getPath());
	}
}

class MappingA_underTest_mapController extends MappingA {
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
