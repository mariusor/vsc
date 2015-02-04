<?php
namespace tests\res\presentation\views\XmlView;
use vsc\presentation\views\XmlView;

/**
 * @covers \vsc\presentation\views\XmlView::display()
 */
class display extends \PHPUnit_Framework_TestCase
{
	public function testUseless()
	{
		$o = new XmlView();
		$this->assertEquals('', $o->display('test'));
	}
}
