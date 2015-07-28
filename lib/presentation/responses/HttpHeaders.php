<?php
/**
 * @author Marius Orcsik <marius@habarnam.ro>
 * @created 2015-07-28
 */
namespace vsc\presentation\responses;

use vsc\infrastructure\vsc;

trait HttpHeaders
{
	abstract public function getServerProtocol();
	abstract public function getStatus();
	abstract public function getLocation();

	abstract public function getContentType();
	abstract public function getContentDisposition();
	abstract public function getContentEncoding();
	abstract public function getContentLanguage();
	abstract public function getContentLength();
	abstract public function getContentLocation();
	abstract public function getContentMd5();

	abstract public function getCacheControl();
	abstract public function getDate();
	abstract public function getETag();
	abstract public function getExpires();
	abstract public function getLastModified();


	/**
	 * @return bool
	 */
	public function outputStatusHeader () {
		if (vsc::isCli()) { return false; }
		if ($this->getStatus()) {
			header(self::getHttpStatusString($this->getServerProtocol(), $this->getStatus()));
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
		if (is_array($this->aHeaders)) {
			foreach ($this->aHeaders as $sHeaderName => $sHeaderValue) {
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
