<?php
/**
 * @package vsc_presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.04.09
 */
vsc\import ('presentation/views');
class vscJsView extends vscPlainTextView {
	protected $sContentType = 'application/x-javascript';
	protected $sFolder = 'js';
}