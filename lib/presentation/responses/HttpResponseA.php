<?php
/**
 * @package presentation
 * @subpackage responses
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.30
 */
namespace vsc\presentation\responses;

use vsc\domain\models\ErrorModel;
use vsc\infrastructure\vsc;
use vsc\infrastructure\Base;
use vsc\infrastructure\Object;
use vsc\presentation\requests\HttpRequestTypes;
use vsc\presentation\views\ViewA;

abstract class HttpResponseA extends Object {
	private $sServerProtocol;
	private $iStatus;
	private $aAllow = array(HttpRequestTypes::GET, HttpRequestTypes::POST, HttpRequestTypes::PUT, HttpRequestTypes::DELETE);
	private $sCacheControl;
	private $sContentEncoding;
	private $sContentLanguage;
	private $iContentLength;
	private $sContentLocation;
	private $sContentDisposition;
	private $sContentMd5;
	private $sDate;
	private $sETag;
	private $sExpires;
	private $sLastModified;
	private $sLocation;
	private $oView;

	protected $aHeaders;
	protected $sContentType;

	public function __construct() {
		if (is_array($_SERVER)) {
			if (array_key_exists('SERVER_PROTOCOL', $_SERVER)) {
				$this->sServerProtocol = $_SERVER['SERVER_PROTOCOL'];
			}
		}
	}

	public function setStatus($iStatus) {
		if (!HttpResponseType::isValidStatus($iStatus)) {
			throw new ExceptionResponse('['.$iStatus.'] is not a valid '.$this->getServerProtocol().' status');
		}

		$this->iStatus = $iStatus;
	}

	/**
	 * @param string $sValue
	 * @return void
	 */
	public function setLocation($sValue) {
		$this->sLocation = $sValue;
	}

	public function addHeader($sName, $sValue) {
		$this->aHeaders[$sName] = $sValue;
	}

	/**
	 * @param string $sValue
	 * @return void
	 */
	public function setCacheControl($sValue) {
		$this->sCacheControl = $sValue;
	}

	/**
	 * @param string $sValue
	 * @return void
	 */
	public function setContentEncoding($sValue) {
		$this->sContentEncoding = $sValue;
	}

	/**
	 * @param string $sValue
	 * @return void
	 */
	public function setContentLanguage($sValue) {
		$this->sContentLanguage = $sValue;
	}

	/**
	 * @param integer $iValue
	 * @return void
	 */
	public function setContentLength($iValue) {
		$this->iContentLength = $iValue;
	}

	/**
	 * @param string $sValue
	 * @return void
	 */
	public function setContentLocation($sValue) {
		$this->sContentLocation = $sValue;
	}

	/**
	 * @param string $sValue
	 * @return void
	 */
	public function setContentDisposition($sValue) {
		$this->sContentDisposition = $sValue;
	}

	/**
	 * @param string $sValue
	 * @return void
	 */
	public function setContentMd5($sValue) {
		$this->sContentMd5 = $sValue;
	}

	/**
	 * @param string $sValue
	 * @return void
	 */
	public function setContentType($sValue) {
		$this->sContentType = $sValue;
	}

	/**
	 * @param string $sValue
	 * @return void
	 */
	public function setDate($sValue) {
		$this->sDate = $sValue;
	}

	/**
	 * @param string $sValue
	 * @return void
	 */
	public function setETag($sValue) {
		$this->sETag = $sValue;
	}

	/**
	 * @param string $sValue
	 * @return void
	 */
	public function setExpires($sValue) {
		$this->sExpires = $sValue;
	}

	/**
	 * @param string $sValue
	 * @return void
	 */
	public function setLastModified($sValue) {
		$this->sLastModified = $sValue;
	}

	/**
	 * @return string
	 */
	public function getLocation() {
		return $this->sLocation;
	}

	/**
	 * @return string
	 */
	public function getCacheControl() {
		return $this->sCacheControl;
	}

	/**
	 * @return string
	 */
	public function getContentEncoding() {
		return $this->sContentEncoding;
	}

	/**
	 * @return string
	 */
	public function getContentLanguage() {
		return $this->sContentLanguage;
	}

	/**
	 * @return integer
	 */
	public function getContentLength() {
		return $this->iContentLength;
	}

	/**
	 * @return string
	 */
	public function getContentLocation() {
		return $this->sContentLocation;
	}

	/**
	 * @return string
	 */
	public function getContentDisposition() {
		return $this->sContentDisposition;
	}

	/**
	 * @return string
	 */
	public function getContentMd5() {
		return $this->sContentMd5;
	}

	/**
	 * @return string
	 */
	public function getContentType() {
		return $this->sContentType;
	}

	/**
	 * @return string
	 */
	public function getDate() {
		return $this->sDate;
	}

	/**
	 * @return string
	 */
	public function getETag() {
		return $this->sETag;
	}

	/**
	 * @return string
	 */
	public function getExpires() {
		return $this->sExpires;
	}

	/**
	 * @return string
	 */
	public function getLastModified() {
		return $this->sLastModified;
	}

	/**
	 * @return string
	 */
	public function getServerProtocol() {
		return $this->sServerProtocol;
	}

	/**
	 * @param string $sProtocol
	 */
	public static function getHttpStatusString($sProtocol, $iStatus) {
		return $sProtocol.' '.HttpResponseType::getStatus($iStatus);
	}

	public function getStatus() {
		return $this->iStatus;
	}

	/**
	 * @return bool
	 */
	public function outputHeaders() {
		if (vsc::isCli()) { return false; }
		if (headers_sent()) {
			header_remove();
		}
		if ($this->getStatus())
			header(self::getHttpStatusString($this->getServerProtocol(), $this->getStatus()));

		$sLocation = $this->getLocation();
		if ($sLocation) {
			header('Location:'.$sLocation);
			return true;
			// end headers
		}

		$sContentType = $this->getContentType();
		if ($sContentType) {
			header('Content-Type: '.$sContentType);
		}
		$sCacheControl = $this->getCacheControl();
		if ($sCacheControl) {
			header('Cache-Control: '.$sCacheControl);
		}
		$sContentDisposition = $this->getContentDisposition();
		if ($sContentDisposition) {
			header('Content-Disposition: '.$sContentDisposition);
		}
		$sContentEncoding = $this->getContentEncoding();
		if ($sContentEncoding) {
			header('Content-Encoding: '.$sContentEncoding);
		}
		$sContentLanguage = $this->getContentLanguage();
		if ($sContentLanguage) {
			header('Content-Language: '.$sContentLanguage);
		}
		$iContentLength = $this->getContentLength();
		if ($iContentLength !== null) {
			header('Content-Length: '.$iContentLength);
		}
		$sContentLocation = $this->getContentLocation();
		if ($sContentLocation) {
			header('Content-Location: '.$sContentLocation);
		}
		$sMd5 = $this->getContentMd5();
		if ($sMd5) {
			header('Content-MD5: '.$sMd5);
		}
		$sDate = $this->getDate();
		if ($sDate) {
			header('Date: '.$sDate);
		}
		$sETag = $this->getETag();
		if ($sETag) {
			header('ETag: "'.$sETag.'"'); // the ETag is enclosed in quotes (i imagine it's because it might contain EOL's ?)
		}
		$sExpires = $this->getExpires();
		if ($sExpires) {
			header('Expires: '.$sExpires);
		}
		$sLastModified = $this->getLastModified();
		if ($sLastModified) {
			header('Last-Modified: '.$sLastModified);
		}
		if (is_array($this->aHeaders)) {
			foreach ($this->aHeaders as $sHeaderName => $sHeaderValue) {
				if (is_null($sHeaderValue)) {
					header_remove($sHeaderName);
				} else {
					header($sHeaderName.': '.$sHeaderValue);
				}
			}
		}
		return true;
	}

	/**
	 * @param ViewA $oView
	 * @return string
	 */
	public function setView(ViewA $oView) {
		$this->oView = $oView;
	}

	/**
	 * @returns ViewA
	 */
	public function getView() {
		if (!ViewA::isValid($this->oView)) {
			$this->oView = new Base();
		}
		return $this->oView;
	}

	public function getOutput() {
		$sResponseBody = null;
		if (ViewA::isValid($this->getView())) {
			$this->setContentType($this->getView()->getContentType());
		} else {
			$this->setContentType('*/*');
		}

		$oRequest = vsc::getEnv()->getHttpRequest();
		try {
			if (!$oRequest->isHead() && !$this->isRedirect()) {
				$oView = $this->getView();
				$sResponseBody = $oView->getOutput();
			} else {
				$this->setContentLength(0);
			}
		} catch (ExceptionResponseError $r) {
			$this->setStatus($r->getCode());
			$oView->setModel(new ErrorModel($r));

			$sResponseBody = $oView->getOutput();
		}
		return $sResponseBody;
	}

	public function isSuccess() {
		return ($this->getStatus() == HttpResponseType::OK);
	}

	public function isRedirect() {
		return ($this->getStatus() >= 300 && $this->getStatus() < 400);
	}

	public function isUserError() {
		return ($this->getStatus() >= 400 && $this->getStatus() < 500);
	}

	public function isServerError() {
		return ($this->getStatus() >= 500 && $this->getStatus() < 600);
	}

	public function isError() {
		return ($this->isUserError() || $this->isServerError());
	}
}
