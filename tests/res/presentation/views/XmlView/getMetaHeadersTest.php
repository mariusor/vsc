<?php
namespace tests\res\presentation\views\XmlView;
use vsc\presentation\views\XmlView;

/**
 * @covers \vsc\presentation\views\XmlView::getMetaHeaders()
 */
class getMetaHeaders extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new XmlView();
		$this->assertEquals([], $o->getMetaHeaders());
	}
}
