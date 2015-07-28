<?php
/**
 * @package presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.11.19
 */
namespace vsc\presentation\views;

class RssView extends ViewA implements RssViewI {
	protected $sContentType = 'application/rss+xml';
	protected $sFolder = 'rss';

	/**
	 * @return string
	 */
	public function getDescription() {
		return '';
	}
	/**
	 * @return string
	 */
	public function getLanguage() {
		return '';
	}
	/**
	 * @return string
	 */
	public function getLastBuildDate() {
		return '';
	}
}
