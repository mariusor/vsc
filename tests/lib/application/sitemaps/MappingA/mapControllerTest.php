<?php
namespace tests\lib\application\sitemaps\MappingA;
use fixtures\application\controllers\GenericFrontController;
use vsc\application\sitemaps\ClassMap;
use vsc\application\sitemaps\ControllerMap;
use vsc\application\sitemaps\MappingA;

/**
 * @covers \vsc\application\sitemaps\MappingA::mapController()
 */
class mapController extends \PHPUnit_Framework_TestCase
{
	public function testMapClass()
	{
		$o = new MappingA_underTest_mapController();
		$oMap = $o->mapController ('.*', GenericFrontController::class);

		$this->assertInstanceOf(MappingA::class, $oMap);
		$this->assertInstanceOf(ClassMap::class, $oMap);
	}

	public function testMapFile()
	{
		$o = new MappingA_underTest_mapController();
		$oMap = $o->mapController ('.*', VSC_FIXTURE_PATH . 'application/controllers/GenericFrontController.php');

		$this->assertInstanceOf(MappingA::class, $oMap);
		$this->assertInstanceOf(ControllerMap::class, $oMap);
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
