<?php
/**
 * @package vsc_presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.11.19
 */
interface vscXhtmlViewI {
	function getScripts();

	function getContent();

	function getMetaHeaders();

	function getStyleSheets();
}