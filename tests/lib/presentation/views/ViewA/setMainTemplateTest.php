<?php
namespace tests\lib\presentation\views\ViewA;
use fixtures\presentation\views\testView;

/**
 * @covers \vsc\presentation\views\ViewA::setMainTemplate()
 */
class setMainTemplate extends \PHPUnit_Framework_TestCase
{
	public function testSetMainTemplate ()
	{
		$o = new testView();

		$t = VSC_FIXTURE_PATH . 'templates/main.tpl.php';
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
			$this->assertInstanceOf(\vsc\Exception::class, $e);
			$this->assertInstanceOf(\vsc\ExceptionPath::class, $e);
		}

		$this->assertEmpty($o->getMainTemplate());
	}
}
