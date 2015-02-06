<?php
namespace tests\res\presentation\views\TxtView;
use vsc\presentation\views\TxtView;

/**
 * @covers \vsc\presentation\views\TxtView::display()
 */
class display extends \PHPUnit_Framework_TestCase
{
	public function testUseless()
	{
		$o = new TxtView();
		$this->assertEquals('', $o->display('test'));
	}
}
