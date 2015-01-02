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

	}
	public function tearDown() {}

	public function testConstruct () {
		$o = new RESTProcessorFixture();

		$oMap = new ClassMap(RESTProcessorFixture::class, '.*');
		$o->setMap($oMap);

		$this->assertInstanceOf(RESTProcessorFixture::class, $o);
		$this->assertInstanceOf(\vsc\rest\application\processors\RESTProcessorA::class, $o);
		$this->assertInstanceOf(\vsc\application\processors\ProcessorA::class, $o);
	}

	public function testNoValidContentTypes () {
		$o = new RESTProcessorFixture();

		$oMap = new ClassMap(RESTProcessorFixture::class, '.*');
		$o->setMap($oMap);

		$this->assertFalse($o->validContentType(ContentTypeFixtures::Everything));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Image));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Png));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Gif));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Application));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Xml));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Json));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Text));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Css));
	}

	public function testNoValidHttpMethods () {
		$o = new RESTProcessorFixture();

		$oMap = new ClassMap(RESTProcessorFixture::class, '.*');
		$o->setMap($oMap);

		$this->assertFalse($o->validRequestMethod(HttpRequestTypes::GET));
		$this->assertFalse($o->validRequestMethod(HttpRequestTypes::HEAD));
		$this->assertFalse($o->validRequestMethod(HttpRequestTypes::POST));
		$this->assertFalse($o->validRequestMethod(HttpRequestTypes::PUT));
		$this->assertFalse($o->validRequestMethod(HttpRequestTypes::DELETE));
		$this->assertFalse($o->validRequestMethod(HttpRequestTypes::OPTIONS));
		$this->assertFalse($o->validRequestMethod(uniqid('GET:')));
	}

	public function assertValidContentType ($sContentType) {
		$o = new RESTProcessorFixture();

		$oMap = new ClassMap(RESTProcessorFixture::class, '.*');
		$o->setMap($oMap);

		$aContentTypes = array($sContentType);
		$o->setContentTypes($aContentTypes);

		$this->assertTrue($o->validContentType(ContentTypeFixtures::Everything));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Image));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Png));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Gif));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Application));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Xml));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Json));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Text));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Css));
	}

	public function testValidContentTypes () {
		$o = new RESTProcessorFixture();

		$oMap = new ClassMap(RESTProcessorFixture::class, '.*');
		$o->setMap($oMap);

		$aContentTypes = array(ContentTypeFixtures::Everything);
		$o->setContentTypes($aContentTypes);
		$this->assertTrue($o->validContentType(ContentTypeFixtures::Everything));
		$this->assertTrue($o->validContentType(ContentTypeFixtures::Image));
		$this->assertTrue($o->validContentType(ContentTypeFixtures::Png));
		$this->assertTrue($o->validContentType(ContentTypeFixtures::Gif));
		$this->assertTrue($o->validContentType(ContentTypeFixtures::Application));
		$this->assertTrue($o->validContentType(ContentTypeFixtures::Xml));
		$this->assertTrue($o->validContentType(ContentTypeFixtures::Json));
		$this->assertTrue($o->validContentType(ContentTypeFixtures::Text));
		$this->assertTrue($o->validContentType(ContentTypeFixtures::Css));

		$aContentTypes = array(ContentTypeFixtures::Image);
		$o->setContentTypes($aContentTypes);
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Everything));
		$this->assertTrue($o->validContentType(ContentTypeFixtures::Image));
		$this->assertTrue($o->validContentType(ContentTypeFixtures::Png));
		$this->assertTrue($o->validContentType(ContentTypeFixtures::Gif));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Application));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Xml));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Json));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Text));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Css));

		$aContentTypes = array(ContentTypeFixtures::Png);
		$o->setContentTypes($aContentTypes);
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Everything));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Image));
		$this->assertTrue($o->validContentType(ContentTypeFixtures::Png));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Gif));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Application));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Xml));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Json));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Text));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Css));

		$aContentTypes = array(ContentTypeFixtures::Gif);
		$o->setContentTypes($aContentTypes);
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Everything));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Image));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Png));
		$this->assertTrue($o->validContentType(ContentTypeFixtures::Gif));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Application));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Xml));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Json));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Text));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Css));

		$aContentTypes = array(ContentTypeFixtures::Application);
		$o->setContentTypes($aContentTypes);
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Everything));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Image));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Png));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Gif));
		$this->assertTrue($o->validContentType(ContentTypeFixtures::Application));
		$this->assertTrue($o->validContentType(ContentTypeFixtures::Xml));
		$this->assertTrue($o->validContentType(ContentTypeFixtures::Json));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Text));
		$this->assertFalse($o->validContentType(ContentTypeFixtures::Css));
	}
}
