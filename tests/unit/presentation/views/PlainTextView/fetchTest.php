<?php
namespace tests\presentation\views\PlainTextView;
use vsc\application\sitemaps\ClassMap;
use vsc\presentation\views\PlainTextView;

/**
 * @covers \vsc\presentation\views\PlainTextView::fetch()
 */
class fetch extends \BaseUnitTest
{
	public function testUseless()
	{
		$o = new PlainTextView();
		$o->setMap(new ClassMap(self::class, '.*'));
		$this->assertEquals("<h1>fixture</h1>\n", $o->fetch(VSC_MOCK_PATH . 'templates/main.tpl.php'));
	}
}
