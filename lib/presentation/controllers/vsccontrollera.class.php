<?php
/**
 * @package vsc_presentation
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.31
 */
abstract class vscControllerA {
	public function __construct () {
		$args = func_get_args();
//		d ($args, get_class($this));
	}

//	abstract public function init ();
//
//	abstract public function handleRequest (vscHttpRequestA $oHttpRequest);
}