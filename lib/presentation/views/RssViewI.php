<?php
/**
 * @package presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.11.19
 */
namespace vsc\presentation\views;

interface RssViewI {
	function getDescription();
	function getLanguage();
	function getLastBuildDate();
}
