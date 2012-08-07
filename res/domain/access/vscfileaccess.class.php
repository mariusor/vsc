<?php
import ('domain/access');
class vscFileAccess extends vscObject {
	private $sUri;

	private $sCachePath;

	public function __construct ($sUri) {
		$this->sUri = $sUri;
	}

	public function getCachePath () {
		return $this->sCachePath;
	}

	public function setCachePath ($sPath) {
		if (is_dir($sPath)) {
			$this->sCachePath = $sPath;
		}
	}

	public function getLocalPath ($sFile) {
		return  $this->sCachePath . DIRECTORY_SEPARATOR . $sFile;
	}

	public function getSignature ($sUri) {
		return md5 ($sUri . date('Ymd'));
	}

	/**
	 * @param string $sUri
	 * @return bool
	 */
	public function inCache ($sUri) {
		return ( is_file ($this->getLocalPath($this->getSignature ($sUri))) );
	}

	public function loadFromCache ($sUri) {
		return file_get_contents($this->getLocalPath($this->getSignature($sUri)));
	}

	public function cacheFile ($sUri, $sContent) {
		$sFileName = $this->getLocalPath($this->getSignature ($sUri));

		// creating the file
		touch($sFileName);

		if (is_writable($sFileName)) {
			file_put_contents($sFileName, $sContent);
		} else {
			throw new vscExceptionError('Path ['.$sFileName.'] is not writeable.');
		}
	}

	public function isLocalFile () {
		return is_file ($this->sUri);
	}

	public function load () {
		if ($this->isLocalFile($this->sUri) || !$this->inCache ($this->sUri)){
			// @todo: use curl when file_get_contents doesn't work with urls
			$sContent	= file_get_contents ($this->sUri);

			try {
				if (!$this->isLocalFile($this->sUri)) {
					$this->cacheFile ($this->sUri, $sContent);
				}
			} catch (vscExceptionAccess $e) {
				// no cache dir
			} catch (vscExceptionError $e) {
// 				d ($e->getTraceAsString());
			}

			return $sContent;
		} else {
			return $this->loadFromCache ($this->sUri);
		}
	}
}