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
        return (
            stristr($_SERVER['REMOTE_ADDR'], '127.0.0.1') != false ||
            stristr($_SERVER['REMOTE_ADDR'], '192.168') != false
        );
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

	static public function d () {
		$aRgs = func_get_args();
		$iExit = 1;

		$output = '';
		for ($i = 0; $i < ob_get_level(); $i++) {
			// cleaning the buffers
			ob_end_clean();
		}

		foreach ($aRgs as $object) {
			// maybe I should just output the whole array $aRgs
			try {
				ob_start();
				var_dump ($object);
				$output = ob_get_clean();
			} catch (Exception $e) {
				//
			}
		}
		ob_start();
		debug_print_backtrace();

		$output .= ob_get_clean();

		if (!isCli() && self::getHttpRequest()->accepts('text/html')) {
			echo '<pre>' . $output . '</pre>';
		} else {
			echo vscString::stripTags(vscString::br2nl($output));
		}

		exit ();
	}
}
