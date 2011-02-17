<?php
/**
 *
 * @author marius orcsik <marius@habarnam.ro>
 * @date 10.10.15
 */
import ('presentation/views');
class vscHtml5View extends vscXhtmlView {
	protected $sContentType = 'text/html';

	public function getViewFolder () {
		return 'html5';
	}
}