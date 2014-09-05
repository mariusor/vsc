<?php
use vsc\presentation\requests\HttpRequestA;
use fixtures\presentation\requests\PopulatedRequest;
use vsc\presentation\requests\HttpRequestTypes;

class HttpRwRequestTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @var PopulatedRequest
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

	public function testSetTaintedVars() {
		$ExistingTaintedVars = array(
			'module'	=> 'test',
			'cucu'		=> 'mucu',
			'height'	=> 143
		);
		$this->assertEquals($ExistingTaintedVars, $this->state->getTaintedVars());

		$NewTaintedVars = array(
			'ana' => uniqid('val1:'),
			'are' => uniqid('val2:'),
			'mere' => uniqid('val3:')
		);
		$this->state->setTaintedVars($NewTaintedVars, false);
		$this->assertNotEquals($ExistingTaintedVars,$this->state->getTaintedVars());
		$this->assertEquals(array_merge($ExistingTaintedVars, $NewTaintedVars),$this->state->getTaintedVars());
	}

	public function testGetFirstParameter() {
		$this->assertEquals('module',$this->state->getFirstParameter());

		$this->state->setTaintedVars(array(
			'ana' => uniqid('val:')
		));

		$this->assertEquals('ana',$this->state->getFirstParameter());
	}

	public function testGetTaintedVar() {
		$ExistingTaintedVars = array(
			'module'	=> 'test',
			'cucu'		=> 'mucu',
			'height'	=> 143
		);
		foreach ($ExistingTaintedVars as $Key => $Value) {
			$this->assertEquals($Value, $this->state->getTaintedVar($Key));
		}

		$NewTaintedVars = array_merge($ExistingTaintedVars, array(
			'ana' => uniqid('val1:'),
			'are' => uniqid('val2:'),
			'mere' => uniqid('val3:')
		));
		$this->state->setTaintedVars($NewTaintedVars, false);

		foreach ($NewTaintedVars as $Key => $Value) {
			$this->assertEquals($Value, $this->state->getTaintedVar($Key));
		}

		$RandomInexistentVars = array(
			uniqid('key_') => uniqid('val:'),
			uniqid('key_') => uniqid('val:'),
		);

		foreach ($RandomInexistentVars as $Key => $Value) {
			$this->assertNotEquals($Value, $this->state->getTaintedVar($Key));
			$this->assertNull($this->state->getTaintedVar($Key));
		}
	}

	public function testGetVars() {
		$ExistingTaintedVars = array(
			'module'	=> 'test',
			'cucu'		=> 'mucu',
			'height'	=> 143
		);
		$ExistingGetVars	= array('cucu' => 'pasare','ana' => 'are', 'mere' => '', 'test' => 123);
		$ExistingPostVars	= array('postone' => 'are', 'ana' => '');
		$ExistingCookieVars	= array('user' => 'asddsasdad234');

		$ExistingVars = array ();
		$VarOrder = $this->state->getVarOrder();
		foreach ($VarOrder as $sMethod) {
			switch ($sMethod) {
				case 'S':
					break;
				case 'C':
					$ExistingVars = array_merge ($ExistingVars, $ExistingCookieVars);
					break;
				case 'P':
					$ExistingVars = array_merge ($ExistingVars, $ExistingPostVars);
					break;
				case 'G':
					$ExistingVars = array_merge ($ExistingVars, $ExistingGetVars);
					break;
			}
		}

		$this->assertEquals(array_merge($ExistingTaintedVars, $ExistingVars), $this->state->getVars());
	}

	public function testGetVarOrder() {
		$sOrder = ini_get('variables_order');
		for ($i = 0; $i < 4; $i++) {
			// reversing the order
			$VarOrder[$i] = substr($sOrder, $i, 1);
		}

		$this->assertSame($VarOrder, $this->state->getVarOrder());
	}

	public function testHasContentType () {
		$this->assertFalse(HttpRequestA::hasContentType());

		$_SERVER['CONTENT_TYPE'] = 'test/test';
		$this->assertTrue(HttpRequestA::hasContentType());
	}

	public function testHasSession () {
		$this->assertFalse(HttpRequestA::hasSession());

		session_start();
		$this->assertTrue(HttpRequestA::hasSession());

		session_destroy();
		$this->assertFalse(HttpRequestA::hasSession());
	}

	public function testHasGetVars() {
		$this->assertTrue ($this->state->hasGetVars());

		$this->state->setGetVars(null);
		$this->assertFalse ($this->state->hasGetVars());

		$this->state->setGetVars(array('ana' => 'mere'));
		$this->assertTrue ($this->state->hasGetVars());
	}

	public function testHasPostVars() {
		$this->assertTrue ($this->state->hasPostVars());

		$this->state->setPostVars(null);
		$this->assertFalse ($this->state->hasPostVars());

		$this->state->setPostVars(array('ana' => 'mere'));
		$this->assertTrue ($this->state->hasPostVars());
	}

	public function testIsHead () {
		$this->state->setHttpMethod(HttpRequestTypes::HEAD);
		$this->assertTrue ($this->state->isHead());
		$this->assertFalse ($this->state->isGet());
		$this->assertFalse ($this->state->isPost());
		$this->assertFalse ($this->state->isPut());
		$this->assertFalse ($this->state->isDelete());
	}

	public function testIsGet () {
		$this->state->setHttpMethod(HttpRequestTypes::GET);
		$this->assertFalse ($this->state->isHead());
		$this->assertTrue ($this->state->isGet());
		$this->assertFalse ($this->state->isPost());
		$this->assertFalse ($this->state->isPut());
		$this->assertFalse ($this->state->isDelete());
	}

	public function testIsPost () {
		$this->state->setHttpMethod(HttpRequestTypes::POST);
		$this->assertFalse ($this->state->isHead());
		$this->assertFalse ($this->state->isGet());
		$this->assertTrue ($this->state->isPost());
		$this->assertFalse ($this->state->isPut());
		$this->assertFalse ($this->state->isDelete());
	}

	public function testIsPut () {
		$this->state->setHttpMethod(HttpRequestTypes::PUT);
		$this->assertFalse ($this->state->isHead());
		$this->assertFalse ($this->state->isGet());
		$this->assertFalse ($this->state->isPost());
		$this->assertTrue ($this->state->isPut());
		$this->assertFalse ($this->state->isDelete());
	}

	public function testIsDelete () {
		$this->state->setHttpMethod(HttpRequestTypes::DELETE);
		$this->assertFalse ($this->state->isHead());
		$this->assertFalse ($this->state->isGet());
		$this->assertFalse ($this->state->isPost());
		$this->assertFalse ($this->state->isPut());
		$this->assertTrue ($this->state->isDelete());
	}

	public function testGetHttpMethod () {
		$this->state->setHttpMethod(HttpRequestTypes::HEAD);
		$this->assertEquals (HttpRequestTypes::HEAD, $this->state->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::GET, $this->state->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::POST, $this->state->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::PUT, $this->state->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::DELETE, $this->state->getHttpMethod());

		$this->state->setHttpMethod(HttpRequestTypes::GET);
		$this->assertNotEquals (HttpRequestTypes::HEAD, $this->state->getHttpMethod());
		$this->assertEquals (HttpRequestTypes::GET, $this->state->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::POST, $this->state->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::PUT, $this->state->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::DELETE, $this->state->getHttpMethod());

		$this->state->setHttpMethod(HttpRequestTypes::POST);
		$this->assertNotEquals (HttpRequestTypes::HEAD, $this->state->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::GET, $this->state->getHttpMethod());
		$this->assertEquals (HttpRequestTypes::POST, $this->state->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::PUT, $this->state->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::DELETE, $this->state->getHttpMethod());

		$this->state->setHttpMethod(HttpRequestTypes::PUT);
		$this->assertNotEquals (HttpRequestTypes::HEAD, $this->state->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::GET, $this->state->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::POST, $this->state->getHttpMethod());
		$this->assertEquals (HttpRequestTypes::PUT, $this->state->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::DELETE, $this->state->getHttpMethod());

		$this->state->setHttpMethod(HttpRequestTypes::DELETE);
		$this->assertNotEquals (HttpRequestTypes::HEAD, $this->state->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::GET, $this->state->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::POST, $this->state->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::PUT, $this->state->getHttpMethod());
		$this->assertEquals (HttpRequestTypes::DELETE, $this->state->getHttpMethod());
	}

}
