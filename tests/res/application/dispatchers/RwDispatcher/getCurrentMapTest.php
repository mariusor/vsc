<?php
namespace tests\res\application\dispatchers\RwDispatcher;
use vsc\application\dispatchers\RwDispatcher;
use vsc\application\sitemaps\ClassMap;
use vsc\application\sitemaps\MappingA;
use vsc\application\processors\EmptyProcessor;
use vsc\ExceptionError;

/**
 * @covers \vsc\application\dispatchers\RwDispatcher::getCurrentMap()
 */
class getCurrentMap extends \PHPUnit_Framework_TestCase
{
	public function testCurrentMapWithEmptyMaps()
	{
		$aMaps = array();

		$o = new RwDispatcher();
		$oCurrentMap = $o->getCurrentMap($aMaps);
		$this->assertInstanceOf(MappingA::class, $oCurrentMap);
		$this->assertInstanceOf(ClassMap::class, $oCurrentMap);
		$this->assertEquals('', $oCurrentMap->getRegex());
		$this->assertEquals('', $oCurrentMap->getPath());
	}

	public function testCurrentMapWithEnvRequest()
	{
		$sRegex = '.*';
		$aMaps = array();
		$aMaps[$sRegex] = new ClassMap(EmptyProcessor::class, $sRegex);

		$o = new RwDispatcher();
		$oCurrentMap = $o->getCurrentMap($aMaps);
		$this->assertInstanceOf(MappingA::class, $oCurrentMap);
		$this->assertInstanceOf(ClassMap::class, $oCurrentMap);
		$this->assertEquals($sRegex, $oCurrentMap->getRegex());
		$this->assertEquals(EmptyProcessor::class, $oCurrentMap->getPath());
	}

	public function testCurrentMapWithInvalidRegex()
	{
		set_error_handler(
			function ($iSeverity, $sMessage, $sFilename, $iLineNo) {
				\vsc\exceptions_error_handler($iSeverity, $sMessage, $sFilename, $iLineNo);
			}
		);

		$sRegex = '\\';
		$aMaps = array();
		$aMaps[$sRegex] = new ClassMap(EmptyProcessor::class, $sRegex);

		$o = new RwDispatcher();
		try {
			$o->getCurrentMap($aMaps);
		} catch (\ErrorException $err) {
			$errMessage =<<<START
preg_match_all(): No ending delimiter '#' found<br/> Offending regular expression: <span style="font-weight:normal">#\#iu</span>
START;

			$this->assertInstanceOf(ExceptionError::class, $err);
			$this->assertEquals($errMessage, $err->getMessage());
		}
	}
}
