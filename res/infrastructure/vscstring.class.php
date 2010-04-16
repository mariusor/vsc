<?php
/**
 * @package vsc_infrastructure
 * @author marius orcsik <marius@habarnam.ro>
 * @date 10.04.16
 */
class vscString {

	static function stripTags ($sString) {
		return ereg_replace("<[a-z\/\":=]*>", '', $sString);
	}

	static function stripEntities ($sString) {
		return html_entity_decode($sString, ENT_NOQUOTES, 'UTF-8');
	}

	static function _echo ($sString, $iTimes = 1) {
		for ($i = 0; $i <= $iTimes; $i++)
			echo $sString;
	}

	/**
	 * returns an end of line, based on the environment
	 * @return string
	 */
	static public function nl () {
		return isCli() ? "\n" : '<br/>' . "\n";
	}

	/**
	 * Removes all extra spaces from a string
	 * @param string $s
	 * @return string
	 */
	static public function alltrim ($sString) {
		return trim (ereg_replace('/\s+/', ' ', $sString));
	}
}