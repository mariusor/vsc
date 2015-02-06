<?php
namespace tests\res\presentation\views\TxtView;
use vsc\presentation\views\TxtView;

/**
 * @covers \vsc\presentation\views\TxtView::append()
 */
class append extends \PHPUnit_Framework_TestCase
{
	public function testUseless()
	{
		$key = 'test';
		$value = uniqid('test:');
		$o = new TxtView();
		$this->assertEmpty($o->append($key, $value));
	}
}
