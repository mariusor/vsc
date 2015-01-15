<?php
/**
 * @package presentation
 * @subpackage helpers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 13.01.02
 */
namespace vsc\presentation\helpers;

use vsc\domain\models\ModelA;
use vsc\infrastructure\Null;
use vsc\presentation\views\ViewA;

class ViewHelperA extends Null /* implements ViewI  */ {
	private $sName;

	/**
	 * @var ModelA
	 */
	private $oModel;

	/**
	 * @var ViewA
	 */
	private $oView;

	/**
	 * @param ViewA $oView
	 * @return void
	 */
	public function setView (ViewA $oView) {
		$this->oView = $oView;
	}

	/**
	 * @returns ViewA
	 */
	public function getView () {
		return $this->oView;
	}

	/**
	 * @param ModelA $oModel
	 * @return void
	 */
	public function setModel (ModelA $oModel) {
		$this->oModel = $oModel;
	}

	/**
	 * @returns ModelA
	 */
	public function getModel () {
		return $this->oModel;
	}
}
