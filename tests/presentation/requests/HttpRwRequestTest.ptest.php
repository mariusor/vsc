<?php
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\RwHttpRequest;
use \_fixtures\presentation\requests\PopulatedRequest;

class HttpRwRequestTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @var HttpRequestA
	 */
	private $state;

	public function setUp () {
		$_GET		= array ('ana' => 'are', 'mere' => '');
		$_POST		= array ('postone' => 'are', 'ana' => '');
		$_SERVER	= array (
			'SERVER_SOFTWARE' => 'lighttpd',
			'PHP_SELF' => '/',
			'REQUEST_URI' => '/ana:are/test:123/',
			'HTTP_ACCEPT' => 'application/html,text/html;charset=UTF8,image/*'
		);

		$this->state = new RwHttpRequest();
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
		$this->markTestSkipped('Still to decide the accepts() logic');
		$oRequest = new PopulatedRequest();

		$Everything = '*/*';

		$Image = 'image/*';
		$Png = 'image/png';
		$Gif = 'image/gif';

		$Application = 'application/*';
		$Xml = 'application/xml';
		$Json = 'application/json';

		$oRequest->addHttpAccept($Png);
		$this->assertFalse($this->state->accepts($Everything));
		$this->assertFalse($this->state->accepts($Application));
		$this->assertFalse($this->state->accepts($Xml));
		$this->assertFalse($this->state->accepts($Json));
		$this->assertTrue($this->state->accepts($Image));
		$this->assertTrue($this->state->accepts($Png));
		$this->assertFalse($this->state->accepts($Gif));

		$oRequest->addHttpAccept($Gif);
		$this->assertFalse($this->state->accepts($Everything));
		$this->assertFalse($this->state->accepts($Application));
		$this->assertFalse($this->state->accepts($Xml));
		$this->assertFalse($this->state->accepts($Json));
		$this->assertFalse($this->state->accepts($Image));
		$this->assertFalse($this->state->accepts($Png));
		$this->assertTrue($this->state->accepts($Gif));

		$oRequest->addHttpAccept($Image);
		$this->assertFalse($this->state->accepts($Everything));
		$this->assertFalse($this->state->accepts($Application));
		$this->assertFalse($this->state->accepts($Xml));
		$this->assertFalse($this->state->accepts($Json));
		$this->assertTrue($this->state->accepts($Image));
		$this->assertTrue($this->state->accepts($Png));
		$this->assertTrue($this->state->accepts($Gif));

		$oRequest->addHttpAccept($Application);
		$this->assertFalse($this->state->accepts($Everything));
		$this->assertTrue($this->state->accepts($Application));
		$this->assertTrue($this->state->accepts($Xml));
		$this->assertTrue($this->state->accepts($Json));
		$this->assertFalse($this->state->accepts($Image));
		$this->assertFalse($this->state->accepts($Png));
		$this->assertFalse($this->state->accepts($Gif));

		$oRequest->addHttpAccept($Json);
		$this->assertFalse($this->state->accepts($Everything));
		$this->assertFalse($this->state->accepts($Application));
		$this->assertFalse($this->state->accepts($Xml));
		$this->assertTrue($this->state->accepts($Json));
		$this->assertFalse($this->state->accepts($Image));
		$this->assertFalse($this->state->accepts($Png));
		$this->assertFalse($this->state->accepts($Gif));

		$oRequest->addHttpAccept($Xml);
		$this->assertFalse($this->state->accepts($Everything));
		$this->assertFalse($this->state->accepts($Application));
		$this->assertTrue($this->state->accepts($Xml));
		$this->assertFalse($this->state->accepts($Json));
		$this->assertFalse($this->state->accepts($Image));
		$this->assertFalse($this->state->accepts($Png));
		$this->assertFalse($this->state->accepts($Gif));

		$oRequest->addHttpAccept($Everything);
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
