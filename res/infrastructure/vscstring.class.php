<?php
/**
 * @package vsc_infrastructure
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.04.16
 */
class vscString {

	static function br2nl ($sString) {
		return preg_replace('/<br\/?>/i', "\n", $sString);
	}

	static function stripTags ($sString) {
		return strip_tags($sString);
	}

	static function stripEntities ($sString) {
		return html_entity_decode($sString, ENT_NOQUOTES, 'UTF-8');
	}

	static function _echo ($sString, $iTimes = 1) {
		for ($i = 0; $i < $iTimes; $i++)
			echo $sString;
	}

	static function stripScriptTags ($sString) {
		return preg_replace('/<script.*\/script>/mi', '', (string)$sString);
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
	static public function allTrim ($sString) {
		return trim (preg_replace('/\s+/m', ' ', $sString));
	}

	static public function encodeEntities ($sString) {
		return htmlentities($sString, ENT_QUOTES, 'UTF-8');
	}

	static public function formatUri ($sUri) {
		$aReplaceWhat	= array (
			'/(&([^(amp;)]))/',
			'/ {1,}/',
		);
		$aReplaceWith 	= array (
			'&amp;\2',
			'+',
		);

		return preg_replace($aReplaceWhat, $aReplaceWith, $sUri);
	}

	static public function truncate ($sString, $iLength, $sEtc = '...') {
		if ($iLength == 0)
			return '';

		if (strlen($sString) > $iLength) {
			$iLength -= strlen($sEtc);
			$sString = preg_replace('/\s+?(\S+)?$/', '', substr($sString, 0, $iLength+1));
			return substr($sString, 0, $iLength) . $sEtc;
		} else {
			return $sString;
		}
	}
	
	static public function truncate ($sString, $iLength, $sEtc = '...') {
		if ($iLength == 0)
			return '';

		if (strlen($sString) > $iLength) {
			$iLength -= strlen($sEtc);
			$sString = preg_replace('/\s+?(\S+)?$/', '', substr($sString, 0, $iLength+1));
			return substr($sString, 0, $iLength) . $sEtc;
		} else {
			return $sString;
		}
	}
}