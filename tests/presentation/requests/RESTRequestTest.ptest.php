<?php
use fixtures\presentation\requests\PopulatedRESTRequest;
use vsc\presentation\responses\HttpResponseType;
use vsc\Exception;

class RESTRequestTest extends PHPUnit_Framework_TestCase {
	/**
	 * @var PopulatedRESTRequest
	 */
	public $state;

	public function setUp() {
		$this->state = new PopulatedRESTRequest();
	}

	public function tearDown() {
	}

	public function testThrowExceptionEmptyContentType()
	{
		$this->state->constructRawVars();

		try {
			$this->state->getRawVars();
		} catch (Exception $e) {
			$this->assertInstanceOf('\\vsc\\Exception', $e);
			$this->assertInstanceOf('\\vsc\\presentation\\ExceptionPresentation', $e);
			$this->assertInstanceOf('\\vsc\\presentation\\requests\\ExceptionRequest', $e);

			$this->assertEquals('Can not process a request with an empty content-type', $e->getMessage());
		}
	}

	public function testThrowExceptionUnkownContentType() {
		try {
			$this->state->setContentType('application/xml');
			$this->state->getRawVars();
		} catch (Exception $e) {
			$this->assertInstanceOf('\\vsc\\Exception', $e);
			$this->assertInstanceOf('\\vsc\\presentation\\ExceptionPresentation', $e);
			$this->assertInstanceOf('\\vsc\\presentation\\requests\\ExceptionRequest', $e);

			$this->assertEquals('This content-type [application/xml] is not supported', $e->getMessage());
		}
	}

	public function testGetRawVarsJsonData()
	{
		$testVal = array();
		$testVal['ana'] = 'mere';
		$testVal['gigel'] = 'pere';
		$testVal['random'] = uniqid('test:');

		$this->state->setContentType('application/json');
		$this->state->constructRawVars(json_encode($testVal));

		$aRawVars = $this->state->getRawVars();
		$this->assertEquals($testVal, $aRawVars);
		$this->assertEquals($testVal['ana'], $aRawVars['ana']);
		$this->assertEquals($testVal['gigel'], $aRawVars['gigel']);
		$this->assertEquals($testVal['random'], $aRawVars['random']);
	}

	public function testHasVarJsonData()
	{
		$testVal = array();
		$testVal['ana'] = 'mere';
		$testVal['gigel'] = 'pere';
		$testVal['random'] = uniqid('test:');

		$this->state->setContentType('application/json');
		$this->state->constructRawVars(json_encode($testVal));

		$this->assertTrue($this->state->hasRawVar('ana'));
		$this->assertTrue($this->state->hasVar('ana'));
		$this->assertTrue($this->state->hasRawVar('gigel'));
		$this->assertTrue($this->state->hasVar('gigel'));
		$this->assertTrue($this->state->hasRawVar('random'));
		$this->assertTrue($this->state->hasVar('random'));

		$testVal = new stdClass();
		$testVal->ana = 'mere';
		$testVal->gigel = 'pere';
		$testVal->random = uniqid('test:');

		$this->state->setContentType('application/json');
		$this->state->constructRawVars(json_encode($testVal));

		$this->assertTrue($this->state->hasRawVar('ana'));
		$this->assertTrue($this->state->hasVar('ana'));
		$this->assertTrue($this->state->hasRawVar('gigel'));
		$this->assertTrue($this->state->hasVar('gigel'));
		$this->assertTrue($this->state->hasRawVar('random'));
		$this->assertTrue($this->state->hasVar('random'));
	}

	public function testRawGetVarJsonData()
	{
		$testVal = array();
		$testVal['ana'] = 'mere';
		$testVal['gigel'] = 'pere';
		$testVal['random'] = uniqid('test:');

		$this->state->setContentType('application/json');
		$this->state->constructRawVars(json_encode($testVal));

		$this->assertEquals($testVal['ana'], $this->state->getRawVar('ana'));
		$this->assertEquals($testVal['gigel'], $this->state->getRawVar('gigel'));
		$this->assertEquals($testVal['random'], $this->state->getRawVar('random'));

		$testVal = new stdClass();
		$testVal->ana = 'mere';
		$testVal->gigel = 'pere';
		$testVal->random = uniqid('test:');

		$this->state->setContentType('application/json');
		$this->state->constructRawVars(json_encode($testVal));

		$this->assertEquals($testVal->ana, $this->state->getRawVar('ana'));
		$this->assertEquals($testVal->gigel, $this->state->getRawVar('gigel'));
		$this->assertEquals($testVal->random, $this->state->getRawVar('random'));
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

	public function testHasVar_ParentVar() {
		$this->state->setContentType('application/json');

		$this->assertFalse($this->state->hasVar('gigel'));
		$this->assertFalse($this->state->hasVar('random'));

		// GET var
		$this->assertTrue($this->state->hasVar('cucu')); // 'cucu' => 'pasare','ana' => 'are', 'mere' => '', 'test' => 123
		$this->assertTrue($this->state->hasVar('ana'));
		$this->assertTrue($this->state->hasVar('test'));
		// POST var
		$this->assertTrue($this->state->hasVar('postone')); // 'postone' => 'are', 'ana' => ''
		$this->assertTrue($this->state->hasVar('ana'));
		// Cookie var
		$this->assertTrue($this->state->hasVar('user')); // 'user' => 'asddsasdad234'

		PopulatedRESTRequest::startSession();

		$_SESSION['ala'] = uniqid('ala:');
		$_SESSION['bala'] = '##';
		// Session var
		$this->assertTrue($this->state->hasVar('ala')); // 'ala' =>  uniqid('ala:'), 'bala' => '##'
		$this->assertTrue($this->state->hasVar('bala'));
	}


	public function testValidContentType () {
		$this->assertTrue($this->state->validContentType('application/json'));
		$this->assertFalse($this->state->validContentType('text/plain'));
	}
}
 
