<?php
/**
 * @package vsc_presentation
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.30
 */
abstract class vscFrontControllerA {
	/**
	 * @return vscHttpResponseA
	 */
	abstract public function getResponse (vscControllerA $oProcessController);
}