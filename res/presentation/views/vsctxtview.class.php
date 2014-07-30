<?php
/**
 * @package vsc_presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.04.09
 */
namespace vsc\presentation\views;

vsc\import ('presentation/views');
class vscTxtView extends vscViewA implements vscViewI {
	protected $sContentType = 'text/plain';
	protected $sFolder		= 'txt';
}