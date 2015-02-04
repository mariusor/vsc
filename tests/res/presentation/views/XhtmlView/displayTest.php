<?php
namespace tests\res\presentation\views\XhtmlView;
use vsc\presentation\views\XhtmlView;

/**
 * @covers \vsc\presentation\views\XhtmlView::display()
 */
class display extends \PHPUnit_Framework_TestCase
{
	public function testUseless()
	{
		$o = new XhtmlView();
		$this->assertEquals('', $o->display('test'));
	}
}
