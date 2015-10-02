<?php
namespace tests\lib\presentation\views\ViewA;
use mocks\presentation\views\testView;
use vsc\application\sitemaps\ClassMap;
use mocks\domain\models\ModelFixture;
use vsc\Exception;
use vsc\presentation\views\ExceptionView;

/**
 * @covers \vsc\presentation\views\ViewA::getOutput()
 */
class getOutput extends \PHPUnit_Framework_TestCase
{
	public function testGetOutput()
	{
		$o = new testView();

		try {
			$o->getOutput();
		} catch (\Exception $e) {
			$this->assertInstanceOf(Exception::class, $e);
			$this->assertInstanceOf(ExceptionView::class, $e);
		}

		$t = 'main.tpl.php';
		$oMap = new ClassMap(__FILE__, '\A.*\Z');
		$oMap->setTemplatePath(VSC_MOCK_PATH . 'templates/');
		$oMap->setTemplate($t);

		$o->setMap($oMap);

		$f = new ModelFixture();
		$o->setModel ($f);

		$output = $o->getOutput();
		$this->assertEquals(file_get_contents(VSC_MOCK_PATH . 'templates/' . $t), $output);
	}
}
