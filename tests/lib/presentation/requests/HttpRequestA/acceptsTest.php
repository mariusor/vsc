<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use fixtures\presentation\requests\PopulatedRequest;
use fixtures\presentation\requests\PopulatedRESTRequest;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::accepts()
 */
class accepts extends \PHPUnit_Framework_TestCase
{

	public function testAcceptsApplicationHtml () {
		$o = new PopulatedRequest();
		$this->assertTrue($o->accepts('application/html'));
	}

	public function testAcceptsTextHtml () {
		$o = new PopulatedRequest();
		$this->assertTrue($o->accepts('text/html'));
	}

	public function testNotAcceptsApplicationJson () {
		$o = new PopulatedRequest();
		$this->assertFalse($o->accepts('application/json'));
	}

	public function testAcceptsImagePng () {
		$o = new PopulatedRequest();
		$this->assertTrue($o->accepts('image/png'));
	}

	public function testAccepts () {
		$o = new PopulatedRequest();
		$Everything = '*/*';
		$Image = 'image/*';
		$Png = 'image/png';
		$Gif = 'image/gif';
		$Application = 'application/*';
		$Xml = 'application/xml';
		$Json = 'application/json';

		$o->setHttpAccept($Png);
		$this->assertFalse($o->accepts($Everything));
		$this->assertFalse($o->accepts($Application));
		$this->assertFalse($o->accepts($Xml));
		$this->assertFalse($o->accepts($Json));
		$this->assertFalse($o->accepts($Image));
		$this->assertTrue($o->accepts($Png));
		$this->assertFalse($o->accepts($Gif));

		$o->setHttpAccept($Gif);
		$this->assertFalse($o->accepts($Everything));
		$this->assertFalse($o->accepts($Application));
		$this->assertFalse($o->accepts($Xml));
		$this->assertFalse($o->accepts($Json));
		$this->assertFalse($o->accepts($Image));
		$this->assertFalse($o->accepts($Png));
		$this->assertTrue($o->accepts($Gif));

		$o->setHttpAccept($Image);
		$this->assertFalse($o->accepts($Everything));
		$this->assertFalse($o->accepts($Application));
		$this->assertFalse($o->accepts($Xml));
		$this->assertFalse($o->accepts($Json));
		$this->assertTrue($o->accepts($Image));
		$this->assertTrue($o->accepts($Png));
		$this->assertTrue($o->accepts($Gif));

		$o->setHttpAccept($Application);
		$this->assertFalse($o->accepts($Everything));
		$this->assertTrue($o->accepts($Application));
		$this->assertTrue($o->accepts($Xml));
		$this->assertTrue($o->accepts($Json));
		$this->assertFalse($o->accepts($Image));
		$this->assertFalse($o->accepts($Png));
		$this->assertFalse($o->accepts($Gif));

		$o->setHttpAccept($Json);
		$this->assertFalse($o->accepts($Everything));
		$this->assertFalse($o->accepts($Application));
		$this->assertFalse($o->accepts($Xml));
		$this->assertTrue($o->accepts($Json));
		$this->assertFalse($o->accepts($Image));
		$this->assertFalse($o->accepts($Png));
		$this->assertFalse($o->accepts($Gif));

		$o->setHttpAccept($Xml);
		$this->assertFalse($o->accepts($Everything));
		$this->assertFalse($o->accepts($Application));
		$this->assertTrue($o->accepts($Xml));
		$this->assertFalse($o->accepts($Json));
		$this->assertFalse($o->accepts($Image));
		$this->assertFalse($o->accepts($Png));
		$this->assertFalse($o->accepts($Gif));

		$o->setHttpAccept($Everything);
		$this->assertTrue($o->accepts($Everything));
		$this->assertTrue($o->accepts($Application));
		$this->assertTrue($o->accepts($Xml));
		$this->assertTrue($o->accepts($Json));
		$this->assertTrue($o->accepts($Image));
		$this->assertTrue($o->accepts($Png));
		$this->assertTrue($o->accepts($Gif));
	}

	public function testAcceptsFromRawRequest () {
		$o = new PopulatedRESTRequest();

		$Everything = '*/*';
		$Image = 'image/*';
		$Png = 'image/png';
		$Gif = 'image/gif';
		$Application = 'application/*';
		$Xml = 'application/xml';
		$Json = 'application/json';

		$o->setHttpAccept($Png);
		$this->assertFalse($o->accepts($Everything));
		$this->assertFalse($o->accepts($Application));
		$this->assertFalse($o->accepts($Xml));
		$this->assertFalse($o->accepts($Json));
		$this->assertFalse($o->accepts($Image));
		$this->assertTrue($o->accepts($Png));
		$this->assertFalse($o->accepts($Gif));

		$o->setHttpAccept($Gif);
		$this->assertFalse($o->accepts($Everything));
		$this->assertFalse($o->accepts($Application));
		$this->assertFalse($o->accepts($Xml));
		$this->assertFalse($o->accepts($Json));
		$this->assertFalse($o->accepts($Image));
		$this->assertFalse($o->accepts($Png));
		$this->assertTrue($o->accepts($Gif));

		$o->setHttpAccept($Image);
		$this->assertFalse($o->accepts($Everything));
		$this->assertFalse($o->accepts($Application));
		$this->assertFalse($o->accepts($Xml));
		$this->assertFalse($o->accepts($Json));
		$this->assertTrue($o->accepts($Image));
		$this->assertTrue($o->accepts($Png));
		$this->assertTrue($o->accepts($Gif));

		$o->setHttpAccept($Application);
		$this->assertFalse($o->accepts($Everything));
		$this->assertTrue($o->accepts($Application));
		$this->assertTrue($o->accepts($Xml));
		$this->assertTrue($o->accepts($Json));
		$this->assertFalse($o->accepts($Image));
		$this->assertFalse($o->accepts($Png));
		$this->assertFalse($o->accepts($Gif));

		$o->setHttpAccept($Json);
		$this->assertFalse($o->accepts($Everything));
		$this->assertFalse($o->accepts($Application));
		$this->assertFalse($o->accepts($Xml));
		$this->assertTrue($o->accepts($Json));
		$this->assertFalse($o->accepts($Image));
		$this->assertFalse($o->accepts($Png));
		$this->assertFalse($o->accepts($Gif));

		$o->setHttpAccept($Xml);
		$this->assertFalse($o->accepts($Everything));
		$this->assertFalse($o->accepts($Application));
		$this->assertTrue($o->accepts($Xml));
		$this->assertFalse($o->accepts($Json));
		$this->assertFalse($o->accepts($Image));
		$this->assertFalse($o->accepts($Png));
		$this->assertFalse($o->accepts($Gif));

		$o->setHttpAccept($Everything);
		$this->assertTrue($o->accepts($Everything));
		$this->assertTrue($o->accepts($Application));
		$this->assertTrue($o->accepts($Xml));
		$this->assertTrue($o->accepts($Json));
		$this->assertTrue($o->accepts($Image));
		$this->assertTrue($o->accepts($Png));
		$this->assertTrue($o->accepts($Gif));
	}
}
