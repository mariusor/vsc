<?php
/**
 * @package vsc_presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.10.15
 */
namespace vsc\presentation\views;

vsc\import ('presentation/views');
class vscHtml5View extends vscXhtmlView {
	protected $sContentType = 'text/html';
	protected $sFolder = 'html5';
}