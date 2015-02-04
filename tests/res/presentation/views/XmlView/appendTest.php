<?php
namespace tests\res\presentation\views\XmlView;
use vsc\presentation\views\XmlView;

/**
 * @covers \vsc\presentation\views\XmlView::append()
 */
class append extends \PHPUnit_Framework_TestCase
{
	public function testUseless()
	{
		$key = 'test';
		$value = uniqid('test:');
		$o = new XmlView();
		$this->assertEmpty($o->append($key, $value));
	}
}
