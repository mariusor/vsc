<?php
namespace tests\res\presentation\views\XmlView;
use vsc\presentation\views\XmlView;

/**
 * @covers \vsc\presentation\views\XmlView::assign()
 */
class assign extends \PHPUnit_Framework_TestCase
{
	public function testUseless()
	{
		$key = 'test';
		$value = uniqid('test:');
		$o = new XmlView();
		$this->assertNull($o->assign($key, $value));
	}
}
