<?php
/**
 * @package vsc_presentation
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.31
 */
class vsc {
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
		import ('presentation/requests');
		if (!(self::$oRequest instanceof vscHttpRequestA)){
			self::$oRequest = new vscRwHttpRequest();
		}

		return self::$oRequest;
	}

	/**
	 * @return vscHttpDispatcherA
	 */
	static public function getDispatcher () {
		import ('presentation/dispatchers');
		if (!(self::$oDispatcher instanceof vscDispatcherA)){
			self::$oDispatcher = new vscRwDispatcher();
		}
		return self::$oDispatcher;
	}
}