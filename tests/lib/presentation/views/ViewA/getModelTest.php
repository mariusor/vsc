<?php
namespace tests\lib\presentation\views\ViewA;
use fixtures\presentation\views\testView;
use fixtures\domain\models\ModelFixture;
use vsc\domain\models\ModelA;
use vsc\Exception;
use vsc\presentation\views\ExceptionView;

/**
 * @covers \vsc\presentation\views\ViewA::getModel()
 */
class getModel extends \PHPUnit_Framework_TestCase
{
	public function testGetModel ()
	{
		$o = new testView();

		try {
			// empty
			$o->getModel ();
		} catch (\Exception $e) {
			$this->assertInstanceOf(Exception::class, $e);
			$this->assertInstanceOf(ExceptionView::class, $e);
		}

		$f = new ModelFixture();
		$o->setModel ($f);

		$m = $o->getModel();

		$this->assertInstanceOf(ModelA::class, $m);
		$this->assertInstanceOf(ModelFixture::class, $m);
		$this->assertEquals($f, $m);
	}
}
