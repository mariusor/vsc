<?php
namespace tests\application\sitemaps\MappingA;
use mocks\application\controllers\FrontControllerFixture;
use mocks\application\sitemaps\MapFixture;

/**
 * @covers \vsc\application\sitemaps\MappingA::setTemplate()
 */
class setTemplate extends \BaseUnitTest
{
	public function testSetTemplate ()
	{
		$oMap = new MappingA_underTest_setTemplate(FrontControllerFixture::class, '\A.*\Z');

		$n = 'main.tpl.php';
		$oMap->setTemplate($n);

		$this->assertEquals($n, $oMap->getTemplate());
	}
}

class MappingA_underTest_setTemplate extends MapFixture {}
