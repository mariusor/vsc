<?php
namespace tests\res\presentation\views\RssView;
use vsc\presentation\views\RssView;

/**
 * @covers \vsc\presentation\views\RssView::assign()
 */
class assign extends \PHPUnit_Framework_TestCase
{
	public function testUseless()
	{
		$key = 'test';
		$value = uniqid('test:');
		$o = new RssView();
		$this->assertNull($o->assign($key, $value));
	}
}
