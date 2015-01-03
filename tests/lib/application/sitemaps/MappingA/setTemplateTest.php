<?php
namespace tests\lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\MappingA;

/**
 * @covers \vsc\application\sitemaps\MappingA::setTemplate()
 */
class setTemplate extends \PHPUnit_Framework_TestCase
{
	public function testSetTemplate ()
	{
		$oMap = new MappingA_underTest_setTemplate(\fixtures\application\controllers\GenericFrontController::class, '\A.*\Z');

		$n = 'main.tpl.php';
		$oMap->setTemplate($n);

		$this->assertEquals($n, $oMap->getTemplate());
	}
}

class MappingA_underTest_setTemplate extends MappingA {}
