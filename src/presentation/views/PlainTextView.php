<?php
/**
 * @package presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2011.02.17
 */
namespace vsc\presentation\views;

use vsc\domain\models\StaticFileModel;

class PlainTextView extends ViewA implements ViewInterface {
	protected $sContentType = 'text/plain';
	protected $sFolder = 'txt';

	public function fetch($includePath) {
		$oModel = $this->getModel();
		/* @var StaticFileModel $oModel */
		if (StaticFileModel::isValid($oModel)) {
			return $oModel->getFileContent();
		} else {
			return parent::fetch($includePath);
		}
	}
}
