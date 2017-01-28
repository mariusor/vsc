<?php
namespace tests\infrastructure\urls\Url;
use vsc\infrastructure\urls\Url;

/**
 * @covers \vsc\infrastructure\urls\Url::addPath()
 */
class addPathTest extends \BaseUnitTest {

	public function testAddPath () {
		$sLocalHost = 'localhost';
		$sStr = 'ana/are/mere';

		$oUrl = new Url();
		$oUrl->setHost($sLocalHost);
		$oUrl->addPath($sStr);

		$this->assertEquals('//' . $sLocalHost . '/' . $sStr . '/', $oUrl->getUrl());
	}

	public function testAddRelativePathWithParentDirectory () {
		$sLocalHost = 'localhost';
		$sStr = 'ana/../are/mere';

		$oUrl = new Url();
		$oUrl->setScheme('http');
		$oUrl->setHost($sLocalHost);
		$oUrl->addPath($sStr);

		$sParentStr = substr($sStr, strpos($sStr, '../') + strlen ('../'));
		$this->assertEquals('http://' . $sLocalHost . '/' . $sParentStr . '/', $oUrl->getUrl());
	}

	public function testAddRelativePathWithCurrentDirectory () {
		$sLocalHost = 'localhost';
		$sStr = 'ana/./are/mere';

		$oUrl = new Url();
		$oUrl->setScheme('http');
		$oUrl->setHost($sLocalHost);
		$oUrl->addPath($sStr);

		$sCurrentStr = str_replace('./', '', $sStr);
		$this->assertEquals('http://' . $sLocalHost . '/' . $sCurrentStr . '/', $oUrl->getUrl());
	}

}
