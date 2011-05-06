<?php
abstract class vscAccessA extends vscObject {
	private $oGrammarHelper;

	public function setGrammarHelper (SQLGenericDriver $oGrammarHelper) {
		$this->oGrammarHelper = $oGrammarHelper;
	}

	/**
	 * @return SQLGenericDriver
	 */
	public function getGrammarHelper () {
		return $this->oGrammarHelper;
	}
}