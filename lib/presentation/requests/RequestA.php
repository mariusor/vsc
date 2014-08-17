<?php
/**
 * @package presentation
 * @subpackage requests
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.07.13
 */
namespace vsc\presentation\requests;

use vsc\infrastructure\vsc;
use vsc\infrastructure\Object;
use vsc\Exception;

abstract class RequestA extends Object {
	private $aVarOrder;

	public function getSessionVars() {
		return $_SESSION;
	}

	/**
	 * @return string[]
	 */
	public function getVarOrder () {
		if (count($this->aVarOrder) != 4){
			// get gpc order
			$sOrder = ini_get('variables_order');
			for ($i = 0; $i < 4; $i++) {
				// reversing the order
				$this->aVarOrder[$i] = substr($sOrder, $i, 1);
			}
		}
		return $this->aVarOrder;
	}

	public function getVars () {
		$aRet = array ();
		foreach ($this->getVarOrder() as $sMethod) {
			switch ($sMethod) {
			case 'S':
				if (self::hasSession()) {
					$aRet = array_merge ($aRet, $_SESSION);
				}
				break;
			}
		}
		return $aRet;
	}

	/**
	 * @param string $sVarName
	 * @throws Exception
	 * @return mixed
	 */
	public function getVar ($sVarName) {
		foreach ($this->getVarOrder() as $sMethod) {
			switch ($sMethod) {
			case 'S':
				$mVal = $this->getSessionVar($sVarName);
				break;
			}
			if ($mVal) {
				return $mVal;
			}
		}
		return null;
	}

	public function hasSessionVar ($sVarName) {
		return array_key_exists($sVarName, $_SESSION);
	}

	public function hasSession () {
		return (session_id() != '');
	}

	static public function startSession ($sSessionName = null) {
		if ( ((double)PHP_VERSION >= 5.4 && session_status() == PHP_SESSION_DISABLED) ) {
			throw new ExceptionRequest('Sessions are not available');
		}

		if ( ((double)PHP_VERSION >= 5.4 && session_status() == PHP_SESSION_NONE) || session_id() == "") {
			$oRequest = vsc::getEnv()->getHttpRequest();
			session_set_cookie_params(0, '/', $oRequest->getUriObject()->getDomain(), HttpRequestA::isSecure(), true);
			session_start();
			if (!is_null($sSessionName)) {
				session_name($sSessionName);
			}
		}
	}

	static public function destroySession () {
		$aSessionCookieParams = session_get_cookie_params();

		session_unset();
		session_destroy();
		session_write_close();
		setcookie(session_name(), "", -1, $aSessionCookieParams['path'], $aSessionCookieParams['domain'], $aSessionCookieParams['secure'], $aSessionCookieParams['httponly']);
	}

	public function hasVar($sVarName) {
		return (
			$this->hasSessionVar($sVarName)
		);
	}

	/**
	 *
	 * @param string $sVarName
	 * @throws Exception
	 * @return mixed
	 */
	public function getSessionVar ($sVarName) {
		if (array_key_exists($sVarName, $_SESSION)) {
			return self::getDecodedVar($_SESSION[$sVarName]);
		} else {
			return null;
		}
	}

	/**
	 * @param string $sVarName
	 * @param string $sVarValue
	 * @return bool
	 */
	public function setSessionVar ($sVarName, $sVarValue) {
		return $_SESSION[$sVarName] = $sVarValue;
	}

	static protected function getDecodedVar ($mVar) {
		if (is_array($mVar)) {
			foreach ($mVar as $key => $sValue) {
				$mVar[$key] = self::getDecodedVar($sValue);
			}
		} elseif (is_string($mVar)) {
			$mVar = urldecode($mVar);
		}
		return $mVar;
	}
}
