<?php
namespace tests\res\presentation\views\XhtmlView;
use vsc\presentation\views\XhtmlView;

/**
 * @covers \vsc\presentation\views\XhtmlView::getMetaHeaders()
 */
class getMetaHeaders extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new XhtmlView();
		$this->assertEquals([], $o->getMetaHeaders());
	}
}
