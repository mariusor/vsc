<?php
/**
 * @package vsc_presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.11.19
 */
interface vscRssViewI {
	function getUrl();
	function getTitle();
	function getContent();
	function getDescription();
	function getLanguage();
	function getLastBuildDate();
}