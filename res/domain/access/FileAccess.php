<?php
/**
 * @package domain
 * @subpackage access
 * @author marius orcsik <marius@habarnam.ro>
 * @date 12.08.07
 */
namespace vsc\domain\access;

use vsc\infrastructure\Object;
use vsc\ExceptionError;

class FileAccess extends Object {
	private $sUri;

	private $sCachePath;
	protected $saveToCache = true;

	public function __construct ($sUri) {
		$this->sUri = $sUri;
	}

	public function getUri () {
		return $this->sUri;
	}

	public function getCachePath () {
		return $this->sCachePath;
	}

	public function setCachePath ($sPath) {
		if (is_dir($sPath)) {
			$this->sCachePath = $sPath;
		} else {
			throw new ExceptionAccess ('Path ['.$sPath.'] is invalid for cache');
		}
	}

	public function getLocalPath ($sFile) {
		return $this->sCachePath . DIRECTORY_SEPARATOR . $sFile;
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
		if (!touch($sFileName)) {
			throw new ExceptionError('Path ['.$sFileName.'] is not accessible.');
		}

		if (is_writable($sFileName)) {
			file_put_contents($sFileName, $sContent);
		} else {
			throw new ExceptionError('Path ['.$sFileName.'] is not writable.');
		}
	}

	public function isLocalFile () {
		return is_file ($this->sUri);
	}

	public static function getFile ($sPath) {
		return file_get_contents($sPath);
	}

	public function load () {
		if ($this->isLocalFile($this->sUri) || !$this->inCache ($this->sUri)){
			// @todo: use curl when file_get_contents doesn't work with urls
			$sContent	= $this->getFile ($this->sUri);

			try {
				if (!$this->isLocalFile($this->sUri) && $this->saveToCache) {
					$this->cacheFile ($this->sUri, $sContent);
				}
			} catch (ExceptionAccess $e) {
				// no cache dir
			} catch (ExceptionError $e) {
 				//_e ($e->getTraceAsString());
			}

			return $sContent;
		} else {
			return $this->loadFromCache ($this->sUri);
		}
	}
}
