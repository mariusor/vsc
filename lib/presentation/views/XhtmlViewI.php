<?php
/**
 * @package presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.11.19
 */
namespace vsc\presentation\views;

interface XhtmlViewI {
	function getScripts();

	function getContent();

	function getMetaHeaders();

	function getStyles();

	function getSetting($sVar);
}
