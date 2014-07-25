<?php
/**
 * @package vsc_presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.04.09
 */
vsc\import ('presentation/views');
class vscCssView extends vscPlainTextView {
	protected $sContentType = 'text/css';
	protected $sFolder = 'css';
}