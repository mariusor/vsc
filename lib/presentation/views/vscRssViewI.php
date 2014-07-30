<?php
/**
 * @package vsc_presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.11.19
 */
namespace vsc\presentation\views;

interface vscRssViewI {
	function getDescription();
	function getLanguage();
	function getLastBuildDate();
}