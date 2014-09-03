<?php
use fixtures\application\processors\RESTProcessorFixture;
use vsc\application\sitemaps\ClassMap;
use vsc\presentation\requests\HttpRequestTypes;
use fixtures\presentation\requests\ContentTypeFixtures;

class RESTProcessorFixtureTest extends PHPUnit_Framework_TestCase {
	/**
	 * @var  RESTProcessorFixture
	 */
	public $state;

	public function setUp() {
		$this->state = new RESTProcessorFixture();

		$oMap = new ClassMap('\\fixtures\\application\\processors\\RESTProcessorFixture', '.*');
		$this->state->setMap($oMap);
	}
	public function tearDown() {}

	public function testConstruct () {
		$this->assertInstanceOf('\\fixtures\\application\\processors\\RESTProcessorFixture', $this->state);
		$this->assertInstanceOf('\\vsc\\rest\\application\\processors\\RESTProcessorA', $this->state);
		$this->assertInstanceOf('\\vsc\\application\\processors\\ProcessorA', $this->state);
	}

	public function testNoValidContentTypes () {
		$Everything = '*/*';
		$Image = 'image/*';
		$Png = 'image/png';
		$Gif = 'image/gif';
		$Application = 'application/*';
		$Xml = 'application/xml';
		$Json = 'application/json';
		$Text = 'text/plain';
		$Css = 'text/css';

		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Everything));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Image));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Png));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Gif));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Application));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Xml));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Json));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Text));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Css));
	}

	public function testNoValidHttpMethods () {
		$this->assertFalse($this->state->validRequestMethod(HttpRequestTypes::GET));
		$this->assertFalse($this->state->validRequestMethod(HttpRequestTypes::HEAD));
		$this->assertFalse($this->state->validRequestMethod(HttpRequestTypes::POST));
		$this->assertFalse($this->state->validRequestMethod(HttpRequestTypes::PUT));
		$this->assertFalse($this->state->validRequestMethod(HttpRequestTypes::DELETE));
		$this->assertFalse($this->state->validRequestMethod(HttpRequestTypes::OPTIONS));
		$this->assertFalse($this->state->validRequestMethod(uniqid('GET:')));
	}

	public function assertValidContentType ($sContentType) {
		$aContentTypes = array($sContentType);
		$this->state->setContentTypes($aContentTypes);

		$this->assertTrue($this->state->validContentType(ContentTypeFixtures::Everything));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Image));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Png));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Gif));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Application));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Xml));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Json));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Text));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Css));
	}

	public function testValidContentTypes () {
		$aContentTypes = array(ContentTypeFixtures::Everything);
		$this->state->setContentTypes($aContentTypes);
		$this->assertTrue($this->state->validContentType(ContentTypeFixtures::Everything));
		$this->assertTrue($this->state->validContentType(ContentTypeFixtures::Image));
		$this->assertTrue($this->state->validContentType(ContentTypeFixtures::Png));
		$this->assertTrue($this->state->validContentType(ContentTypeFixtures::Gif));
		$this->assertTrue($this->state->validContentType(ContentTypeFixtures::Application));
		$this->assertTrue($this->state->validContentType(ContentTypeFixtures::Xml));
		$this->assertTrue($this->state->validContentType(ContentTypeFixtures::Json));
		$this->assertTrue($this->state->validContentType(ContentTypeFixtures::Text));
		$this->assertTrue($this->state->validContentType(ContentTypeFixtures::Css));

		$aContentTypes = array(ContentTypeFixtures::Image);
		$this->state->setContentTypes($aContentTypes);
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Everything));
		$this->assertTrue($this->state->validContentType(ContentTypeFixtures::Image));
		$this->assertTrue($this->state->validContentType(ContentTypeFixtures::Png));
		$this->assertTrue($this->state->validContentType(ContentTypeFixtures::Gif));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Application));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Xml));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Json));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Text));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Css));

		$aContentTypes = array(ContentTypeFixtures::Png);
		$this->state->setContentTypes($aContentTypes);
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Everything));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Image));
		$this->assertTrue($this->state->validContentType(ContentTypeFixtures::Png));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Gif));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Application));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Xml));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Json));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Text));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Css));

		$aContentTypes = array(ContentTypeFixtures::Gif);
		$this->state->setContentTypes($aContentTypes);
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Everything));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Image));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Png));
		$this->assertTrue($this->state->validContentType(ContentTypeFixtures::Gif));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Application));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Xml));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Json));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Text));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Css));

		$aContentTypes = array(ContentTypeFixtures::Application);
		$this->state->setContentTypes($aContentTypes);
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Everything));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Image));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Png));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Gif));
		$this->assertTrue($this->state->validContentType(ContentTypeFixtures::Application));
		$this->assertTrue($this->state->validContentType(ContentTypeFixtures::Xml));
		$this->assertTrue($this->state->validContentType(ContentTypeFixtures::Json));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Text));
		$this->assertFalse($this->state->validContentType(ContentTypeFixtures::Css));
	}
}
 