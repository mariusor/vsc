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

	public function testHasGetVar() {
		// GET var
		$this->assertTrue($this->state->hasGetVar('cucu')); // 'cucu' => 'pasare','ana' => 'are', 'mere' => '', 'test' => 123
		$this->assertTrue($this->state->hasGetVar('ana'));
		$this->assertTrue($this->state->hasGetVar('test'));
	}

	public function testHasPostVar() {
		// POST var
		$this->assertTrue($this->state->hasPostVar('postone')); // 'postone' => 'are', 'ana' => ''
		$this->assertTrue($this->state->hasPostVar('ana'));
	}

	public function testHasCookieVar() {
		// Cookie var
		$this->assertTrue($this->state->hasCookieVar('user')); // 'user' => 'asddsasdad234'
	}

	public function testHasSessionVar() {
		PopulatedRequest::startSession();

		$_SESSION['ala'] = uniqid('ala:');
		$_SESSION['bala'] = '##';
		// Session var
		$this->assertTrue($this->state->hasSessionVar('ala')); // 'ala' => uniqid('ala:'), 'bala' => '##'
		$this->assertTrue($this->state->hasSessionVar('bala'));
	}

	public function testHasVar() {
		// GET var
		$this->assertTrue($this->state->hasVar('cucu')); // 'cucu' => 'pasare','ana' => 'are', 'mere' => '', 'test' => 123
		$this->assertTrue($this->state->hasVar('ana'));
		$this->assertTrue($this->state->hasVar('test'));
		// POST var
		$this->assertTrue($this->state->hasVar('postone')); // 'postone' => 'are', 'ana' => ''
		$this->assertTrue($this->state->hasVar('ana'));
		// Cookie var
		$this->assertTrue($this->state->hasVar('user')); // 'user' => 'asddsasdad234'

		PopulatedRequest::startSession();

		$_SESSION['ala'] = uniqid('ala:');
		$_SESSION['bala'] = '##';
		// Session var
		$this->assertTrue($this->state->hasVar('ala')); // 'ala' => uniqid('ala:'), 'bala' => '##'
		$this->assertTrue($this->state->hasVar('bala'));
	}

	public function testGetVar() {
		// GET var
		$this->assertEquals('pasare', $this->state->getVar('cucu')); // 'cucu' => 'pasare','ana' => 'are', 'mere' => '', 'test' => 123
		$this->assertEquals('are', $this->state->getVar('ana'));
		$this->assertEquals('', $this->state->getVar('mere'));
		$this->assertEquals(123, $this->state->getVar('test'));
		// POST var
		$this->assertEquals('are', $this->state->getVar('postone')); // 'postone' => 'are', 'ana' => ''
		// Cookie var
		$this->assertEquals('asddsasdad234', $this->state->getVar('user')); // 'user' => 'asddsasdad234'

		// Session var
		PopulatedRequest::startSession();

		$_SESSION['ala'] = uniqid('ala:');
		$_SESSION['bala'] = '##';
		$this->assertEquals($_SESSION['ala'], $this->state->getVar('ala')); // 'ala' => uniqid('ala:'), 'bala' => '##'
		$this->assertEquals($_SESSION['bala'], $this->state->getVar('bala'));
	}
}
