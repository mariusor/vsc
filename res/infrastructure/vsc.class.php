<?php
/**
 * @package vsc_infrastructure
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.31
 */
import ('presentation/requests');
import ('application/dispatchers');
import (dirname(__FILE__));
class vsc extends vscObject {
	static private $oInstance;
	/**
	 * @var vscHttpRequestA
	 */
	static private $oRequest;

	/**
	 * @var vscDispatcherA
	 */
	static private $oDispatcher;

	/**
	 * @return vscHttpRequestA
	 */
	static public function getHttpRequest () {
		if (!vscHttpRequestA::isValid(self::$oRequest)){
			self::$oRequest = new vscRwHttpRequest();
		}

		return self::$oRequest;
	}

	/**
	 * @return vscHttpDispatcherA
	 */
	static public function getDispatcher () {
		if (!vscDispatcherA::isValid(self::$oDispatcher)){
			self::$oDispatcher = new vscRwDispatcher();
		}
		return self::$oDispatcher;
	}

	static public function getEnv () {
		if (!(self::isValid(self::$oInstance))) {
			self::$oInstance = new self();
		}
		return self::$oInstance;
	}

	public function isDevelopment () {
		return true;
	}

	/**
	 * @return bool
	 */
	static public function isCli () {
		return (php_sapi_name() == 'cli');
	}

	static public function name() {
		return 'V<sup>S<sup>C</sup></sup>';
	}

	/**
	 * returns an end of line, based on the environment
	 * @return string
	 */
	static public function nl () {
		return isCli() ? "\n" : '<br/>' . "\n";
	}
}
