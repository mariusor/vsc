<?php
namespace lib\application\controllers\CacheableControllerA;

use fixtures\presentation\requests\PopulatedRequest;
use fixtures\presentation\views\NullView;
use vsc\application\controllers\CacheableControllerA;
use vsc\domain\models\CacheableModelA;
use vsc\domain\models\EmptyModel;
use vsc\presentation\responses\HttpResponse;
use vsc\presentation\responses\HttpResponseType;

/**
 * Class addCacheHeadersTest
 * @package lib\application\controllers\CacheableControllerA
 * @covers \vsc\application\controllers\CacheableControllerA::addCacheHeaders()
 */
class addCacheHeadersTest extends \PHPUnit_Framework_TestCase
{
	public function testWithCacheableModel() {
		$now = new \DateTimeImmutable('now', new \DateTimeZone('GMT'));

		$oResponse = new HttpResponse();
		$oRequest = new PopulatedRequest();
		$oRequest->setIfModifiedSince($now->format('r'));

		$past = $now->sub(new \DateInterval('P2W'));

		$oModel = new CacheableModel_underTest_addCacheHeaders();
		$oModel->setLastModified($past->format('r'));

		$o = new CacheableController_underTest_addCacheHeaders();
		$o->addCacheHeaders($oRequest, $oModel, $oResponse);

		$this->assertEquals($past->format('r'), $oResponse->getLastModified());
		$this->assertEquals($past->add(new \DateInterval('P4W'))->format('r'), $oResponse->getExpires());
		$this->assertEquals(HttpResponseType::NOT_MODIFIED, $oResponse->getStatus());
	}

	public function testWithNotCacheableModel() {
		$oResponse = new HttpResponse();
		$oRequest = new PopulatedRequest();
		$oRequest->setIfNoneMatch(substr(sha1(''), 0, 8));

		$oModel = new EmptyModel();

		$o = new CacheableController_underTest_addCacheHeaders();
		$o->addCacheHeaders($oRequest, $oModel, $oResponse);

		$this->assertEquals($oRequest->getIfNoneMatch(), $oResponse->getETag());
		$this->assertNotNull($oResponse->getCacheControl());
		$this->assertStringStartsWith('public, max-age=', $oResponse->getCacheControl());
		$this->assertEquals(HttpResponseType::NOT_MODIFIED, $oResponse->getStatus());
	}
}

class CacheableModel_underTest_addCacheHeaders extends CacheableModelA {
	private $sModified;
	public function setLastModified($sDate) {
		$this->sModified = $sDate;
	}

	public function getLastModified()
	{
		return $this->sModified;
	}
}

class CacheableController_underTest_addCacheHeaders extends CacheableControllerA {
	public function getDefaultView () {
		return new NullView();
	}
}
