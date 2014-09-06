<?php
use fixtures\presentation\responses\FixtureResponse;
use fixtures\presentation\requests\ContentTypeFixtures;
use vsc\presentation\responses\HttpResponse;
use vsc\presentation\responses\HttpResponseType;
use vsc\presentation\responses\ExceptionResponse;
use vsc\Exception;

class HttpResponseTest extends \PHPUnit_Framework_TestCase {
	public function setUp () {
		// @todo
	}

	public function tearDown () {
		// @todo
	}

	public function testSetGetStatus () {
		$state = new HttpResponse();

		$this->assertNull($state->getStatus());

		$testValue = HttpResponseType::ACCEPTED;
		$state->setStatus($testValue);
		$this->assertEquals($testValue, $state->getStatus());

		$iStatus = 300; // invalid status

		try {
			$state->setStatus($iStatus);
		} catch (Exception $e) {
			$this->assertInstanceOf(ExceptionResponse::class, $e);
			$this->assertEquals('['.$iStatus.'] is not a valid  status', $e->getMessage());
		}

		$iStatus = HttpResponseType::SEE_OTHER;
		$state->setStatus($iStatus);
		$this->assertEquals($iStatus, $state->getStatus());
	}

	public function testSetGetLocation () {
		$state = new HttpResponse();

		$this->assertNull($state->getLocation());

		$sLocation = '/';

		$state->setLocation($sLocation);
		$this->assertEquals($sLocation, $state->getLocation());

		$testValue = 'http://ana.are.mere';
		$state->setLocation($testValue);
		$this->assertEquals($testValue, $state->getLocation());
	}

	public function testGetOutput () {
		$state = new HttpResponse();
		$t = $state->getOutput();

		$this->assertEquals($t, '');
	}

	public function testAddHeader() {
		$state = new FixtureResponse();

		$testHeader = 'Location';
		$testValue = 'http://ana.are.mere';

		$state->addHeader($testHeader, $testValue);
		$this->assertEquals($testValue, $state->getHeader($testHeader));

		$testHeader = 'X-WWW-Authentication';
		$testNonce = uniqid('nonce:');
		$testValue =<<<BEGIN
Digest username="test",
realm="testrealm",
nonce="{$testNonce}",
uri="http://ana.are.mere",
cnonce="",
nc=00000001,
qop="auth",
response=""
BEGIN;

		$state->addHeader($testHeader, $testValue);
		$this->assertEquals($testValue, $state->getHeader($testHeader));
		$this->assertNull($state->getHeader(uniqid('hdr:')));
	}

	public function testSetGetCacheControl (){
		$state = new HttpResponse();

		$this->assertNull($state->getCacheControl());

		$testValue = 'Must-Revalidate';
		$state->setCacheControl($testValue);
		$this->assertEquals($testValue, $state->getCacheControl());
	}

	public function testSetGetContentEncoding (){
		$state = new HttpResponse();

		$this->assertNull($state->getContentEncoding());

		$testValue = 'UTF-8';
		$state->setContentEncoding($testValue);
		$this->assertEquals($testValue, $state->getContentEncoding());
	}

	public function testSetGetContentLanguage (){
		$state = new HttpResponse();

		$this->assertNull($state->getContentLanguage());

		$testValue = 'ro';
		$state->setContentLanguage($testValue);
		$this->assertEquals($testValue, $state->getContentLanguage());
	}

	public function testSetGetContentLength (){
		$state = new HttpResponse();

		$this->assertNull($state->getContentLength());

		$testValue = 666;
		$state->setContentLength($testValue);
		$this->assertEquals($testValue, $state->getContentLength());
	}

	public function testSetGetContentLocation (){
		$state = new HttpResponse();

		$this->assertNull($state->getContentLocation());

		$testValue = 'http://example.com/test';
		$state->setContentLocation($testValue);
		$this->assertEquals($testValue, $state->getContentLocation());
	}

	public function testSetGetContentDisposition (){
		$state = new HttpResponse();

		$this->assertNull($state->getContentDisposition());

		$testValue = uniqid('test');
		$state->setContentDisposition($testValue);
		$this->assertEquals($testValue, $state->getContentDisposition());
	}

	public function testSetGetContentMd5 (){
		$state = new HttpResponse();

		$this->assertNull($state->getContentMd5());

		$testValue = uniqid('test');
		$state->setContentMd5(md5($testValue));
		$this->assertEquals(md5($testValue), $state->getContentMd5());
	}

	public function testSetGetContentType (){
		$state = new HttpResponse();

		$this->assertNull($state->getContentType());

		$testValue = ContentTypeFixtures::Application;
		$state->setContentType($testValue);
		$this->assertEquals($testValue, $state->getContentType());
	}

	public function testSetGetDate () {
		$state = new HttpResponse();

		$this->assertNull($state->getDate());

		date_default_timezone_set('UTC');
		$testValue = date('Y-m-d');
		$state->setDate($testValue);
		$this->assertEquals($testValue, $state->getDate());
	}

	public function testETag () {
		$state = new HttpResponse();

		$this->assertNull($state->getETag());

		$testValue = hash('sha1', uniqid('test:'), 'asd');
		$state->setETag($testValue);
		$this->assertEquals($testValue, $state->getETag());
	}

	public function testSetGetExpires () {
		$state = new HttpResponse();

		$this->assertNull($state->getExpires());

		date_default_timezone_set('UTC');
		$testValue = date('Y-m-d');
		$state->setExpires($testValue);
		$this->assertEquals($testValue, $state->getExpires());
	}

	public function testSetGetLastModified () {
		$state = new HttpResponse();

		$this->assertNull($state->getLastModified());

		date_default_timezone_set('UTC');
		$testValue = date('Y-m-d');
		$state->setLastModified($testValue);
		$this->assertEquals($testValue, $state->getLastModified());
	}

	public function testGetHttpStatusString () {
		$sProtocol = 'HTTP/1.1';
		$iStatus = HttpResponseType::ACCEPTED;
		$FullStatus = $sProtocol . ' ' . HttpResponseType::getStatus($iStatus);
		$this->assertEquals($FullStatus,  HttpResponse::getHttpStatusString($sProtocol, $iStatus));
	}
}
