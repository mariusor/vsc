<?php
namespace tests\lib\infrastructure\urls\Url;
use vsc\infrastructure\urls\Url;

/**
 * @covers \vsc\infrastructure\urls\Url::addPath()
 */
class addPathTest extends \BaseUnitTest {

	public function testAddPath () {
		$sLocalHost = 'http://localhost';
		$sStr = 'ana/are/mere';

		$oUrl = new Url();
		$oUrl->setHost($sLocalHost);
		$oUrl->addPath($sStr);

		$this->assertEquals($sLocalHost . '/' . $sStr . '/', $oUrl->getUrl());
	}

	public function testAddRelativePathWithParentDirectory () {
		$sLocalHost = 'http://localhost';
		$sStr = 'ana/../are/mere';

		$oUrl = new Url();
		$oUrl->setHost($sLocalHost);
		$oUrl->addPath($sStr);

		$sParentStr = substr($sStr, strpos($sStr, '../') + strlen ('../'));
		$this->assertEquals($sLocalHost . '/' . $sParentStr . '/', $oUrl->getUrl());
	}

	public function testAddRelativePathWithCurrentDirectory () {
		$sLocalHost = 'http://localhost';
		$sStr = 'ana/./are/mere';

		$oUrl = new Url();
		$oUrl->setHost($sLocalHost);
		$oUrl->addPath($sStr);

		$sCurrentStr = str_replace('./', '', $sStr);
		$this->assertEquals($sLocalHost . '/' . $sCurrentStr . '/', $oUrl->getUrl());
	}

}
