<?php
namespace tests\res\domain\domain\RssItem;
use vsc\domain\domain\RssItem;

/**
 * @covers \vsc\domain\domain\RssItem::buildObj()
 */
class buildObj extends \PHPUnit_Framework_TestCase
{
	public function testBuildRssItemFromString()
	{
		$domdoc = new \DOMDocument('1.0');
		$domdoc->load(VSC_MOCK_PATH . 'static/sample-rss-2.xml');
		$dom = $domdoc->getElementsByTagName('item')->item(0);
//      <item>
//         <title>Star City</title>
//         <link>http://liftoff.msfc.nasa.gov/news/2003/news-starcity.asp</link>
//         <description>How do Americans get ready to work with Russians aboard the International Space Station? They take a crash course in culture, language and protocol at Russia's &lt;a href="http://howe.iki.rssi.ru/GCTC/gctc_e.htm"&gt;Star City&lt;/a&gt;.</description>
//         <pubDate>Tue, 03 Jun 2003 09:39:21 GMT</pubDate>
//         <guid>http://liftoff.msfc.nasa.gov/2003/06/03.html#item573</guid>
//      </item>

		$o = new RssItem($dom);
		$o->buildObj($dom);

		$title = 'Star City';
		$link = 'http://liftoff.msfc.nasa.gov/news/2003/news-starcity.asp';
		$description =<<<DESC
How do Americans get ready to work with Russians aboard the International Space Station? They take a crash course in culture, language and protocol at Russia's &lt;a href="http://howe.iki.rssi.ru/GCTC/gctc_e.htm"&gt;Star City&lt;/a&gt;.
DESC;
		$pubDate = 'Tue, 03 Jun 2003 09:39:21 GMT';
		$guid = 'http://liftoff.msfc.nasa.gov/2003/06/03.html#item573';

		$this->assertEquals($title,$o->title);
		$this->assertEquals($link,$o->link);
		$this->assertEmpty($o->category);
		$this->assertEquals(html_entity_decode($description),$o->description);
		$this->assertEquals($pubDate,$o->pubDate);
		$this->assertEquals($guid,$o->guid);
	}
}
