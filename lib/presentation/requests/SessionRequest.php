<?php
/**
 * @package presentation
 * @subpackage requests
 * @author marius orcsik <marius@habarnam.ro>
 * @date 21.02.15
 */
namespace vsc\presentation\requests;

use vsc\infrastructure\vsc;

trait SessionRequest {
	protected $aSessionVars = [];

	protected function initSession() {
		if (static::hasSession() && isset($_SESSION)) {
			$this->aSessionVars = $_SESSION;
		}
	}

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
		return $this->aSessionVars;
	}

	/**
	 * @param string $sVarName
	 * @return bool
	 */
	public function hasSessionVar($sVarName) {
		return (
			array_key_exists($sVarName, $this->aSessionVars)
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
					session_set_cookie_params(0, '/', $oRequest->getUriObject()->getHost(), HttpRequestA::isSecure(), true);
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
	 * @return mixed
	 */
	public function getSessionVar($sVarName) {
		if (array_key_exists($sVarName, $this->aSessionVars)) {
			return HttpRequestA::getDecodedVar($this->aSessionVars[$sVarName]);
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
		$this->aSessionVars[$sVarName] = $sVarValue;
		$_SESSION[$sVarName] = $sVarValue;
		return true;
	}

}
