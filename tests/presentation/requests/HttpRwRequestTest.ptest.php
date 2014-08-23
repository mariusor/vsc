<?php
use vsc\presentation\requests\HttpRequestA;
use fixtures\presentation\requests\PopulatedRequest;

class HttpRwRequestTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @var HttpRequestA
	 */
	private $state;

	public function setUp () {
		$this->state = new PopulatedRequest();
	}

	public function tearDown () {
		unset ($this->state);
	}

	public function testGetGetVarCorrect() {
		return $this->assertEquals($_GET['ana'], $this->state->getVar('ana'));
	}

	public function testGetGetVarIncorrect() {
		return $this->assertEquals($this->state->getVar('asdf'), '');
	}

	public function testGetPostVarIncorrect() {
		return $this->assertNotEquals($_POST['ana'], $this->state->getVar('ana'));
	}

	public function testGetPostVarCorrect() {
		return $this->assertEquals($_POST['postone'], $this->state->getVar('postone'));
	}

	public function testGetTaintedVarCorrect() {
		return $this->assertEquals('123', $this->state->getVar('test'));
	}

	public function testAcceptsApplicationHtml () {
		return $this->assertTrue($this->state->accepts('application/html'));
	}

	public function testAcceptsTextHtml () {
		return $this->assertTrue($this->state->accepts('text/html'));
	}

	public function testNotAcceptsApplicationJson () {
		return $this->assertFalse($this->state->accepts('application/json'));
	}

	public function testAcceptsImagePng () {
		return $this->assertTrue($this->state->accepts('image/png'));
	}

	public function testAccepts () {
		$Everything = '*/*';
		$Image = 'image/*';
		$Png = 'image/png';
		$Gif = 'image/gif';
		$Application = 'application/*';
		$Xml = 'application/xml';
		$Json = 'application/json';

		$this->state->setHttpAccept($Png);
		$this->assertFalse($this->state->accepts($Everything));
		$this->assertFalse($this->state->accepts($Application));
		$this->assertFalse($this->state->accepts($Xml));
		$this->assertFalse($this->state->accepts($Json));
		$this->assertFalse($this->state->accepts($Image));
		$this->assertTrue($this->state->accepts($Png));
		$this->assertFalse($this->state->accepts($Gif));

		$this->state->setHttpAccept($Gif);
		$this->assertFalse($this->state->accepts($Everything));
		$this->assertFalse($this->state->accepts($Application));
		$this->assertFalse($this->state->accepts($Xml));
		$this->assertFalse($this->state->accepts($Json));
		$this->assertFalse($this->state->accepts($Image));
		$this->assertFalse($this->state->accepts($Png));
		$this->assertTrue($this->state->accepts($Gif));

		$this->state->setHttpAccept($Image);
		$this->assertFalse($this->state->accepts($Everything));
		$this->assertFalse($this->state->accepts($Application));
		$this->assertFalse($this->state->accepts($Xml));
		$this->assertFalse($this->state->accepts($Json));
		$this->assertTrue($this->state->accepts($Image));
		$this->assertTrue($this->state->accepts($Png));
		$this->assertTrue($this->state->accepts($Gif));

		$this->state->setHttpAccept($Application);
		$this->assertFalse($this->state->accepts($Everything));
		$this->assertTrue($this->state->accepts($Application));
		$this->assertTrue($this->state->accepts($Xml));
		$this->assertTrue($this->state->accepts($Json));
		$this->assertFalse($this->state->accepts($Image));
		$this->assertFalse($this->state->accepts($Png));
		$this->assertFalse($this->state->accepts($Gif));

		$this->state->setHttpAccept($Json);
		$this->assertFalse($this->state->accepts($Everything));
		$this->assertFalse($this->state->accepts($Application));
		$this->assertFalse($this->state->accepts($Xml));
		$this->assertTrue($this->state->accepts($Json));
		$this->assertFalse($this->state->accepts($Image));
		$this->assertFalse($this->state->accepts($Png));
		$this->assertFalse($this->state->accepts($Gif));

		$this->state->setHttpAccept($Xml);
		$this->assertFalse($this->state->accepts($Everything));
		$this->assertFalse($this->state->accepts($Application));
		$this->assertTrue($this->state->accepts($Xml));
		$this->assertFalse($this->state->accepts($Json));
		$this->assertFalse($this->state->accepts($Image));
		$this->assertFalse($this->state->accepts($Png));
		$this->assertFalse($this->state->accepts($Gif));

		$this->state->setHttpAccept($Everything);
		$this->assertTrue($this->state->accepts($Everything));
		$this->assertTrue($this->state->accepts($Application));
		$this->assertTrue($this->state->accepts($Xml));
		$this->assertTrue($this->state->accepts($Json));
		$this->assertTrue($this->state->accepts($Image));
		$this->assertTrue($this->state->accepts($Png));
		$this->assertTrue($this->state->accepts($Gif));
	}
//	public function testHasBasicAuhtentication () {}
//	public function testHasDigestAuhtentication () {}
//	public function testHasNoAuhtentication () {}
//	public function testSetNoAuhtentication () {}
}
