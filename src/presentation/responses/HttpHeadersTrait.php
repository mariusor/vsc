<?php
/**
 * @author Marius Orcsik <marius@habarnam.ro>
 * @created 2015-07-28
 */
namespace vsc\presentation\responses;

use vsc\infrastructure\vsc;

trait HttpHeadersTrait {
	/**
	 * @return string
	 * @see HttpResponseA::getServerProtocol
	 */
	abstract public function getServerProtocol();
	/**
	 * @return int
	 * @see HttpResponseA::getStatus
	 */
	abstract public function getStatus();
	/**
	 * @return string
	 * @see HttpResponseA::getLocation
	 */
	abstract public function getLocation();

	/**
	 * @return string
	 * @see HttpResponseA::getContentType
	 */
	abstract public function getContentType();
	/**
	 * @return string
	 * @see HttpResponseA::getContentDisposition
	 */
	abstract public function getContentDisposition();
	/**
	 * @return string
	 * @see HttpResponseA::getContentEncoding
	 */
	abstract public function getContentEncoding();
	/**
	 * @return string
	 * @see HttpResponseA::getContentLanguage
	 */
	abstract public function getContentLanguage();
	/**
	 * @return int
	 * @see HttpResponseA::getContentLength
	 */
	abstract public function getContentLength();
	/**
	 * @return string
	 * @see HttpResponseA::getContentLocation
	 */
	abstract public function getContentLocation();
	/**
	 * @return string
	 * @see HttpResponseA::getContentMd5
	 */
	abstract public function getContentMd5();

	/**
	 * @return string
	 * @see HttpResponseA::getCacheControl
	 */
	abstract public function getCacheControl();
	/**
	 * @return string
	 * @see HttpResponseA::getDate
	 */
	abstract public function getDate();
	/**
	 * @return string
	 * @see HttpResponseA::getETag
	 */
	abstract public function getETag();
	/**
	 * @return string
	 * @see HttpResponseA::getExpires
	 */
	abstract public function getExpires();
	/**
	 * @return string
	 * @see HttpResponseA::getLastModified
	 */
	abstract public function getLastModified();

	/**
	 * @return array
	 * @see HttpResponseA::getCustomHeaders
	 */
	abstract protected function getCustomHeaders();


	/**
	 * @return bool
	 */
	public function outputStatusHeader () {
		if (vsc::isCli()) { return false; }
		if ($this->getStatus()) {
			header(HttpResponseA::getHttpStatusString($this->getServerProtocol(), $this->getStatus()));
		}
		return true;
	}

	/**
	 * @return bool
	 */
	protected function outputLocationHeaders() {
		if (vsc::isCli()) { return false; }
		$sLocation = $this->getLocation();
		if ($sLocation) {
			header('Location:' . $sLocation);
			return true;
		}
		return false;
	}

	/**
	 * @return bool
	 */
	public function outputContentHeaders() {
		if (vsc::isCli()) { return false; }
		$sContentType = $this->getContentType();
		if ($sContentType) {
			header('Content-Type: ' . $sContentType);
		}
		$sContentDisposition = $this->getContentDisposition();
		if ($sContentDisposition) {
			header('Content-Disposition: ' . $sContentDisposition);
		}
		$sContentEncoding = $this->getContentEncoding();
		if ($sContentEncoding) {
			header('Content-Encoding: ' . $sContentEncoding);
		}
		$sContentLanguage = $this->getContentLanguage();
		if ($sContentLanguage) {
			header('Content-Language: ' . $sContentLanguage);
		}
		$iContentLength = $this->getContentLength();
		if ($iContentLength !== null) {
			header('Content-Length: ' . $iContentLength);
		}
		$sContentLocation = $this->getContentLocation();
		if ($sContentLocation) {
			header('Content-Location: ' . $sContentLocation);
		}
		$sMd5 = $this->getContentMd5();
		if ($sMd5) {
			header('Content-MD5: ' . $sMd5);
		}
		return true;
	}

	/**
	 * @return bool
	 */
	protected function outputCachingHeaders() {
		if (vsc::isCli()) { return false; }
		$sCacheControl = $this->getCacheControl();
		if ($sCacheControl) {
			header('Cache-Control: ' . $sCacheControl);
		}
		$sDate = $this->getDate();
		if ($sDate) {
			header('Date: ' . $sDate);
		}
		$sETag = $this->getETag();
		if ($sETag) {
			header('ETag: "' . $sETag . '"'); // the ETag is enclosed in quotes (i imagine it's because it might contain EOL's ?)
		}
		$sExpires = $this->getExpires();
		if ($sExpires) {
			header('Expires: ' . $sExpires);
		}
		$sLastModified = $this->getLastModified();
		if ($sLastModified) {
			header('Last-Modified: ' . $sLastModified);
		}

		return true;
	}

	/**
	 * @return bool
	 */
	protected function outputCustomHeaders () {
		if (vsc::isCli()) { return false; }
		$aHeaders = $this->getCustomHeaders();
		if (is_array($aHeaders)) {
			foreach ($aHeaders as $sHeaderName => $sHeaderValue) {
				if (is_null($sHeaderValue)) {
					header_remove($sHeaderName);
				} else {
					header($sHeaderName . ': ' . $sHeaderValue);
				}
			}
		}
		return true;
	}

	/**
	 * @return bool
	 */
	public function outputHeaders() {
		if (vsc::isCli()) { return false; }
		if (headers_sent()) {
			header_remove();
		}

		$this->outputStatusHeader();
		if ($this->outputLocationHeaders()) {
			return true;
		}
		$this->outputContentHeaders();
		$this->outputCachingHeaders();
		$this->outputCustomHeaders();
		return true;
	}
}
