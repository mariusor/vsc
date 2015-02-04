<?php
namespace tests\res\presentation\views\XhtmlView;
use vsc\presentation\views\XhtmlView;

/**
 * @covers \vsc\presentation\views\XhtmlView::append()
 */
class append extends \PHPUnit_Framework_TestCase
{
	public function testUseless()
	{
		$key = 'test';
		$value = uniqid('test:');
		$o = new XhtmlView();
		$this->assertEmpty($o->append($key, $value));
	}
}
