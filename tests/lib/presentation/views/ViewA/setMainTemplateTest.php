<?php
namespace tests\lib\presentation\views\ViewA;
use mocks\presentation\views\testView;
use vsc\Exception;
use vsc\ExceptionPath;

/**
 * @covers \vsc\presentation\views\ViewA::setMainTemplate()
 */
class setMainTemplate extends \PHPUnit_Framework_TestCase
{
	public function testSetMainTemplate ()
	{
		$o = new testView();

		$t = VSC_MOCK_PATH . 'templates/main.tpl.php';
		$o->setMainTemplate($t);

		$this->assertEquals($t, $o->getMainTemplate());
	}

	public function testSetMainTemplateBroken ()
	{
		$o = new testView();

		$t = '';
		try {
			$o->setMainTemplate ( $t );
		} catch (\Exception $e) {
			$this->assertInstanceOf(Exception::class, $e);
			$this->assertInstanceOf(ExceptionPath::class, $e);
		}

		$this->assertEmpty($o->getMainTemplate());
	}
}
