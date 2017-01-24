<?php
namespace tests\res\application\dispatchers\RwDispatcher;
use vsc\application\dispatchers\RwDispatcher;
use vsc\application\processors\ErrorProcessor;
use vsc\application\sitemaps\ClassMap;
use vsc\application\sitemaps\MappingA;
use vsc\application\processors\EmptyProcessor;
use vsc\ExceptionError;

/**
 * @covers \vsc\application\dispatchers\RwDispatcher::getCurrentMap()
 */
class getCurrentMap extends \BaseUnitTest
{
	public function testCurrentMapWithEmptyMaps()
	{
		$aMaps = array();

		$sFullMatch = '\A.*\Z';

		$oCurrentMap = RwDispatcher_underTest_getCurrentMap::getCurrentMap($aMaps);
		$this->assertInstanceOf(MappingA::class, $oCurrentMap);
		$this->assertInstanceOf(ClassMap::class, $oCurrentMap);
		$this->assertEquals($sFullMatch, $oCurrentMap->getRegex());
		$this->assertEquals(ErrorProcessor::class, $oCurrentMap->getPath());
	}

	public function testCurrentMapWithEnvRequest()
	{
		$sRegex = '.*';
		$aMaps = array();
		$aMaps[$sRegex] = new ClassMap(EmptyProcessor::class, $sRegex);

		$oCurrentMap = RwDispatcher_underTest_getCurrentMap::getCurrentMap($aMaps);
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

		try {
			RwDispatcher_underTest_getCurrentMap::getCurrentMap($aMaps);
		} catch (\ErrorException $err) {
			$errMessage =<<<START
preg_match_all(): No ending delimiter '#' found<br/> Offending regular expression: <span style="font-weight:normal">#\#iu</span>
START;

			$this->assertInstanceOf(ExceptionError::class, $err);
			$this->assertEquals($errMessage, $err->getMessage());
		}
	}
}

class RwDispatcher_underTest_getCurrentMap extends RwDispatcher {
	static public function getCurrentMap($aMaps, $sUrl = null) {
		return parent::getCurrentMap($aMaps, $sUrl);
	}
}
