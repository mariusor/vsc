<?php
use vsc\presentation\requests\HttpRequestA;
use fixtures\presentation\requests\PopulatedRequest;
use vsc\presentation\requests\HttpRequestTypes;
use vsc\infrastructure\vsc;

class HttpRwRequestTest extends \PHPUnit_Framework_TestCase {
	public function testGetPostVarIncorrect() {
		$o = new PopulatedRequest();
		$this->assertNotEquals($_POST['ana'], $o->getVar('ana'));
	}

	public function testGetPostVarCorrect() {
		$o = new PopulatedRequest();
		$this->assertEquals($_POST['postone'], $o->getVar('postone'));
	}

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
//	public function testHasBasicAuhtentication () {}
//	public function testHasDigestAuhtentication () {}
//	public function testHasNoAuhtentication () {}
//	public function testSetNoAuhtentication () {}

	public function testHasGetVar() {
		$o = new PopulatedRequest();
		// GET var
		$this->assertTrue($o->hasGetVar('cucu')); // 'cucu' => 'pasare','ana' => 'are', 'mere' => '', 'test' => 123
		$this->assertTrue($o->hasGetVar('ana'));
		$this->assertTrue($o->hasGetVar('test'));
	}

	public function testHasPostVar() {
		$o = new PopulatedRequest();
		// POST var
		$this->assertTrue($o->hasPostVar('postone')); // 'postone' => 'are', 'ana' => ''
		$this->assertTrue($o->hasPostVar('ana'));
	}

	public function testHasCookieVar() {
		$o = new PopulatedRequest();
		// Cookie var
		$this->assertTrue($o->hasCookieVar('user')); // 'user' => 'asddsasdad234'
	}

	public function testHasSessionVar() {
		PopulatedRequest::startSession();

		$o = new PopulatedRequest();

		$_SESSION['ala'] = uniqid('ala:');
		$_SESSION['bala'] = '##';
		// Session var
		$this->assertTrue($o->hasSessionVar('ala')); // 'ala' => uniqid('ala:'), 'bala' => '##'
		$this->assertTrue($o->hasSessionVar('bala'));
	}

	public function testHasVar() {
		$o = new PopulatedRequest();
		// GET var
		$this->assertTrue($o->hasVar('cucu')); // 'cucu' => 'pasare','ana' => 'are', 'mere' => '', 'test' => 123
		$this->assertTrue($o->hasVar('ana'));
		$this->assertTrue($o->hasVar('test'));
		// POST var
		$this->assertTrue($o->hasVar('postone')); // 'postone' => 'are', 'ana' => ''
		$this->assertTrue($o->hasVar('ana'));
		// Cookie var
		$this->assertTrue($o->hasVar('user')); // 'user' => 'asddsasdad234'

		PopulatedRequest::startSession();

		$_SESSION['ala'] = uniqid('ala:');
		$_SESSION['bala'] = '##';
		// Session var
		$this->assertTrue($o->hasVar('ala')); // 'ala' => uniqid('ala:'), 'bala' => '##'
		$this->assertTrue($o->hasVar('bala'));
	}

	public function testGetVar() {
		$o = new PopulatedRequest();
		// GET var
		$this->assertEquals('pasare', $o->getVar('cucu')); // 'cucu' => 'pasare','ana' => 'are', 'mere' => '', 'test' => 123
		$this->assertEquals('are', $o->getVar('ana'));
		$this->assertEquals('', $o->getVar('mere'));
		$this->assertEquals(123, $o->getVar('test'));
		// POST var
		$this->assertEquals('are', $o->getVar('postone')); // 'postone' => 'are', 'ana' => ''
		// Cookie var
		$this->assertEquals('asddsasdad234', $o->getVar('user')); // 'user' => 'asddsasdad234'

		// Session var
		PopulatedRequest::startSession();

		$_SESSION['ala'] = uniqid('ala:');
		$_SESSION['bala'] = '##';
		$this->assertEquals($_SESSION['ala'], $o->getVar('ala')); // 'ala' => uniqid('ala:'), 'bala' => '##'
		$this->assertEquals($_SESSION['bala'], $o->getVar('bala'));
	}


	public function testGetVarOrder() {
		$o = new PopulatedRequest();

		$sOrder = ini_get('variables_order');
		for ($i = 0; $i < 4; $i++) {
			// reversing the order
			$VarOrder[$i] = substr($sOrder, $i, 1);
		}

		$this->assertSame($VarOrder, $o->getVarOrder());
	}

	public function testHasContentType () {
		$this->assertFalse(HttpRequestA::hasContentType());

		$_SERVER['CONTENT_TYPE'] = 'test/test';
		$this->assertTrue(HttpRequestA::hasContentType());
	}

	public function testHasSession () {
		session_destroy();
		$this->assertFalse(HttpRequestA::hasSession());

		@session_start();
		$this->assertTrue(HttpRequestA::hasSession());

		session_destroy();
		$this->assertFalse(HttpRequestA::hasSession());
	}

	public function testHasGetVars() {
		$o = new PopulatedRequest();

		$this->assertTrue ($o->hasGetVars());

		$o->setGetVars(null);
		$this->assertFalse ($o->hasGetVars());

		$o->setGetVars(array('ana' => 'mere'));
		$this->assertTrue ($o->hasGetVars());
	}

	public function testHasPostVars() {
		$o = new PopulatedRequest();

		$this->assertTrue ($o->hasPostVars());

		$o->setPostVars(null);
		$this->assertFalse ($o->hasPostVars());

		$o->setPostVars(array('ana' => 'mere'));
		$this->assertTrue ($o->hasPostVars());
	}

	public function testIsHead () {
		$o = new PopulatedRequest();

		$o->setHttpMethod(HttpRequestTypes::HEAD);
		$this->assertTrue ($o->isHead());
		$this->assertFalse ($o->isGet());
		$this->assertFalse ($o->isPost());
		$this->assertFalse ($o->isPut());
		$this->assertFalse ($o->isDelete());
	}

	public function testIsGet () {
		$o = new PopulatedRequest();

		$o->setHttpMethod(HttpRequestTypes::GET);
		$this->assertFalse ($o->isHead());
		$this->assertTrue ($o->isGet());
		$this->assertFalse ($o->isPost());
		$this->assertFalse ($o->isPut());
		$this->assertFalse ($o->isDelete());
	}

	public function testIsPost () {
		$o = new PopulatedRequest();

		$o->setHttpMethod(HttpRequestTypes::POST);
		$this->assertFalse ($o->isHead());
		$this->assertFalse ($o->isGet());
		$this->assertTrue ($o->isPost());
		$this->assertFalse ($o->isPut());
		$this->assertFalse ($o->isDelete());
	}

	public function testIsPut () {
		$o = new PopulatedRequest();

		$o->setHttpMethod(HttpRequestTypes::PUT);
		$this->assertFalse ($o->isHead());
		$this->assertFalse ($o->isGet());
		$this->assertFalse ($o->isPost());
		$this->assertTrue ($o->isPut());
		$this->assertFalse ($o->isDelete());
	}

	public function testIsDelete () {
		$o = new PopulatedRequest();

		$o->setHttpMethod(HttpRequestTypes::DELETE);
		$this->assertFalse ($o->isHead());
		$this->assertFalse ($o->isGet());
		$this->assertFalse ($o->isPost());
		$this->assertFalse ($o->isPut());
		$this->assertTrue ($o->isDelete());
	}

	public function testGetHttpMethod () {
		$o = new PopulatedRequest();

		$o->setHttpMethod(HttpRequestTypes::HEAD);
		$this->assertEquals (HttpRequestTypes::HEAD, $o->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::GET, $o->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::POST, $o->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::PUT, $o->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::DELETE, $o->getHttpMethod());

		$o->setHttpMethod(HttpRequestTypes::GET);
		$this->assertNotEquals (HttpRequestTypes::HEAD, $o->getHttpMethod());
		$this->assertEquals (HttpRequestTypes::GET, $o->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::POST, $o->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::PUT, $o->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::DELETE, $o->getHttpMethod());

		$o->setHttpMethod(HttpRequestTypes::POST);
		$this->assertNotEquals (HttpRequestTypes::HEAD, $o->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::GET, $o->getHttpMethod());
		$this->assertEquals (HttpRequestTypes::POST, $o->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::PUT, $o->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::DELETE, $o->getHttpMethod());

		$o->setHttpMethod(HttpRequestTypes::PUT);
		$this->assertNotEquals (HttpRequestTypes::HEAD, $o->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::GET, $o->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::POST, $o->getHttpMethod());
		$this->assertEquals (HttpRequestTypes::PUT, $o->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::DELETE, $o->getHttpMethod());

		$o->setHttpMethod(HttpRequestTypes::DELETE);
		$this->assertNotEquals (HttpRequestTypes::HEAD, $o->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::GET, $o->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::POST, $o->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::PUT, $o->getHttpMethod());
		$this->assertEquals (HttpRequestTypes::DELETE, $o->getHttpMethod());
	}

}
