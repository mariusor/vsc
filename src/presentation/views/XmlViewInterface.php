<?php
/**
 * @package presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2012.08.26
 */
namespace vsc\presentation\views;

interface XmlViewInterface {
	function getContent();

	function getMetaHeaders();
}
