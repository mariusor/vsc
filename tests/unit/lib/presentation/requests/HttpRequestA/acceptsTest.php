<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use mocks\presentation\requests\PopulatedRequest;
use mocks\presentation\requests\PopulatedRESTRequest;

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
		$everything = '*/*';
		$image = 'image/*';
		$png = 'image/png';
		$gif = 'image/gif';
		$application = 'application/*';
		$xml = 'application/xml';
		$json = 'application/json';

		$o->setHttpAccept($png);
		$this->assertFalse($o->accepts($everything));
		$this->assertFalse($o->accepts($application));
		$this->assertFalse($o->accepts($xml));
		$this->assertFalse($o->accepts($json));
		$this->assertFalse($o->accepts($image));
		$this->assertTrue($o->accepts($png));
		$this->assertFalse($o->accepts($gif));

		$o->setHttpAccept($gif);
		$this->assertFalse($o->accepts($everything));
		$this->assertFalse($o->accepts($application));
		$this->assertFalse($o->accepts($xml));
		$this->assertFalse($o->accepts($json));
		$this->assertFalse($o->accepts($image));
		$this->assertFalse($o->accepts($png));
		$this->assertTrue($o->accepts($gif));

		$o->setHttpAccept($image);
		$this->assertFalse($o->accepts($everything));
		$this->assertFalse($o->accepts($application));
		$this->assertFalse($o->accepts($xml));
		$this->assertFalse($o->accepts($json));
		$this->assertTrue($o->accepts($image));
		$this->assertTrue($o->accepts($png));
		$this->assertTrue($o->accepts($gif));

		$o->setHttpAccept($application);
		$this->assertFalse($o->accepts($everything));
		$this->assertTrue($o->accepts($application));
		$this->assertTrue($o->accepts($xml));
		$this->assertTrue($o->accepts($json));
		$this->assertFalse($o->accepts($image));
		$this->assertFalse($o->accepts($png));
		$this->assertFalse($o->accepts($gif));

		$o->setHttpAccept($json);
		$this->assertFalse($o->accepts($everything));
		$this->assertFalse($o->accepts($application));
		$this->assertFalse($o->accepts($xml));
		$this->assertTrue($o->accepts($json));
		$this->assertFalse($o->accepts($image));
		$this->assertFalse($o->accepts($png));
		$this->assertFalse($o->accepts($gif));

		$o->setHttpAccept($xml);
		$this->assertFalse($o->accepts($everything));
		$this->assertFalse($o->accepts($application));
		$this->assertTrue($o->accepts($xml));
		$this->assertFalse($o->accepts($json));
		$this->assertFalse($o->accepts($image));
		$this->assertFalse($o->accepts($png));
		$this->assertFalse($o->accepts($gif));

		$o->setHttpAccept($everything);
		$this->assertTrue($o->accepts($everything));
		$this->assertTrue($o->accepts($application));
		$this->assertTrue($o->accepts($xml));
		$this->assertTrue($o->accepts($json));
		$this->assertTrue($o->accepts($image));
		$this->assertTrue($o->accepts($png));
		$this->assertTrue($o->accepts($gif));
	}

	public function testAcceptsFromRawRequest () {
		$o = new PopulatedRESTRequest();

		$everything = '*/*';
		$image = 'image/*';
		$png = 'image/png';
		$gif = 'image/gif';
		$application = 'application/*';
		$xml = 'application/xml';
		$json = 'application/json';

		$o->setHttpAccept($png);
		$this->assertFalse($o->accepts($everything));
		$this->assertFalse($o->accepts($application));
		$this->assertFalse($o->accepts($xml));
		$this->assertFalse($o->accepts($json));
		$this->assertFalse($o->accepts($image));
		$this->assertTrue($o->accepts($png));
		$this->assertFalse($o->accepts($gif));

		$o->setHttpAccept($gif);
		$this->assertFalse($o->accepts($everything));
		$this->assertFalse($o->accepts($application));
		$this->assertFalse($o->accepts($xml));
		$this->assertFalse($o->accepts($json));
		$this->assertFalse($o->accepts($image));
		$this->assertFalse($o->accepts($png));
		$this->assertTrue($o->accepts($gif));

		$o->setHttpAccept($image);
		$this->assertFalse($o->accepts($everything));
		$this->assertFalse($o->accepts($application));
		$this->assertFalse($o->accepts($xml));
		$this->assertFalse($o->accepts($json));
		$this->assertTrue($o->accepts($image));
		$this->assertTrue($o->accepts($png));
		$this->assertTrue($o->accepts($gif));

		$o->setHttpAccept($application);
		$this->assertFalse($o->accepts($everything));
		$this->assertTrue($o->accepts($application));
		$this->assertTrue($o->accepts($xml));
		$this->assertTrue($o->accepts($json));
		$this->assertFalse($o->accepts($image));
		$this->assertFalse($o->accepts($png));
		$this->assertFalse($o->accepts($gif));

		$o->setHttpAccept($json);
		$this->assertFalse($o->accepts($everything));
		$this->assertFalse($o->accepts($application));
		$this->assertFalse($o->accepts($xml));
		$this->assertTrue($o->accepts($json));
		$this->assertFalse($o->accepts($image));
		$this->assertFalse($o->accepts($png));
		$this->assertFalse($o->accepts($gif));

		$o->setHttpAccept($xml);
		$this->assertFalse($o->accepts($everything));
		$this->assertFalse($o->accepts($application));
		$this->assertTrue($o->accepts($xml));
		$this->assertFalse($o->accepts($json));
		$this->assertFalse($o->accepts($image));
		$this->assertFalse($o->accepts($png));
		$this->assertFalse($o->accepts($gif));

		$o->setHttpAccept($everything);
		$this->assertTrue($o->accepts($everything));
		$this->assertTrue($o->accepts($application));
		$this->assertTrue($o->accepts($xml));
		$this->assertTrue($o->accepts($json));
		$this->assertTrue($o->accepts($image));
		$this->assertTrue($o->accepts($png));
		$this->assertTrue($o->accepts($gif));
	}
}
