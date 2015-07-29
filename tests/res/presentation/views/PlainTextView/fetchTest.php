<?php
namespace tests\res\presentation\views\PlainTextView;
use vsc\application\sitemaps\ClassMap;
use vsc\presentation\views\PlainTextView;

/**
 * @covers \vsc\presentation\views\PlainTextView::fetch()
 */
class fetch extends \PHPUnit_Framework_TestCase
{
	public function testUseless()
	{
		$o = new PlainTextView();
		$o->setMap(new ClassMap(self::class, '.*'));
		$this->assertEquals("<h1>fixture</h1>\n", $o->fetch(VSC_FIXTURE_PATH . 'templates/main.tpl.php'));
	}
}
