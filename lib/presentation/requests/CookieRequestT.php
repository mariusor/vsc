<?php
/**
 * @package presentation
 * @subpackage requests
 * @author marius orcsik <marius@habarnam.ro>
 * @date 21.02.15
 */
namespace vsc\presentation\requests;

use vsc\Exception;

trait CookieRequestT {
	protected $aCookieVars = array();

	protected function initCookie() {
		if (isset($_COOKIE)) {
			$this->aCookieVars = $_COOKIE;
		}
	}

	/**
	 * @param string $sVarName
	 * @return bool
	 */
	public function hasCookieVar($sVarName) {
		return array_key_exists($sVarName, $this->aCookieVars);
	}

	/**
	 *
	 * @param string $sVarName
	 * @throws Exception
	 * @return mixed
	 */
	protected function getCookieVar($sVarName) {
		if (array_key_exists($sVarName, $this->aCookieVars)) {
			return self::getDecodedVar($this->aCookieVars[$sVarName]);
		} else {
			return null;
		}
	}

	/**
	 * @return array
	 */
	public function getCookieVars() {
		return $this->aCookieVars;
	}

	/**
	 * @param string $sVarName
	 * @param string $sVarValue
	 * @return bool
	 */
	public function setCookieVar($sVarName, $sVarValue) {
		return setcookie($sVarName, $sVarValue);
	}
}
