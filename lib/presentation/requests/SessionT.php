<?php
/**
 * @package presentation
 * @subpackage requests
 * @author marius orcsik <marius@habarnam.ro>
 * @date 21.02.15
 */
namespace vsc\presentation\requests;

use vsc\infrastructure\vsc;

trait SessionT {

	/**
	 * @return bool
	 */
	public static function hasSession() {
		return (session_id() != '');
	}

	/**
	 * @return array
	 */
	public function getSessionVars() {
		return $_SESSION;
	}

	/**
	 * @param string $sVarName
	 * @return bool
	 */
	public function hasSessionVar($sVarName) {
		return (
			self::hasSession() &&
			isset($_SESSION) &&
			is_array($_SESSION) &&
			array_key_exists($sVarName, $_SESSION)
		);
	}

	/**
	 * @return string
	 */
	public static function getSessionName() {
		return session_id();
	}

	/**
	 * @param string $sSessionName
	 * @throws ExceptionRequest
	 */
	public static function startSession($sSessionName = null) {
		if (!static::hasSession()) {
			if (((double)PHP_VERSION >= 5.4 && session_status() == PHP_SESSION_DISABLED)) {
				throw new ExceptionRequest('Sessions are not available');
			}

			if (((double)PHP_VERSION >= 5.4 && session_status() == PHP_SESSION_NONE)) {
				$oRequest = vsc::getEnv()->getHttpRequest();
				if (!vsc::isCli()) {
					session_set_cookie_params(0, '/', $oRequest->getUriObject()->getDomain(), HttpRequestA::isSecure(), true);
				}
				if (@session_start()) {
					$_SESSION = array();
					if (!is_null($sSessionName)) {
						session_id($sSessionName);
					}
				}
			}
		}
	}

	/**
	 * return void
	 */
	public static function destroySession() {
		$aSessionCookieParams = session_get_cookie_params();

		session_unset();
		session_destroy();
		session_write_close();
		setcookie(session_name(), "", -1, $aSessionCookieParams['path'], $aSessionCookieParams['domain'], $aSessionCookieParams['secure'], $aSessionCookieParams['httponly']);
	}

	/**
	 *
	 * @param string $sVarName
	 * @throws Exception
	 * @return mixed
	 */
	public function getSessionVar($sVarName) {
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
	public function setSessionVar($sVarName, $sVarValue) {
		return $_SESSION[$sVarName] = $sVarValue;
	}

}
