<?php
namespace tests\res\presentation\views\XhtmlView;
use vsc\presentation\views\XhtmlView;

/**
 * @covers \vsc\presentation\views\XhtmlView::getStyles()
 */
class getStyles extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new XhtmlView();
		$this->assertEquals([], $o->getStyles());
	}
}
