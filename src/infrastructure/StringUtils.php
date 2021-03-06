<?php
/**
 * @package infrastructure
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.04.16
 */
namespace vsc\infrastructure;

class StringUtils {

	/**
	 * @param string $sString
	 * @return string
	 */
	public static function br2nl($sString) {
		return preg_replace('/<br\/?>/i', "\n", $sString);
	}

	/**
	 * @param string $sString
	 * @return string
	 */
	public static function stripTags($sString) {
		return strip_tags($sString);
	}

	/**
	 * @param string $sString
	 * @return string
	 */
	public static function stripEntities($sString) {
		return html_entity_decode($sString, ENT_NOQUOTES, 'UTF-8');
	}

	/**
	 * @param string $sString
	 * @param int $iTimes
	 */
	public static function _echo($sString, $iTimes = 1) {
		for ($i = 0; $i < $iTimes; $i++)
			echo $sString;
	}

	/**
	 * @param string $sString
	 * @return string
	 */
	public static function stripScriptTags($sString) {
		return preg_replace('/<script.*\/script>/mi', '', (string)$sString);
	}

	/**
	 * returns an end of line, based on the environment
	 * @return string
	 */
	public static function nl() {
		return vsc::isCli() ? "\n" : '<br/>' . "\n";
	}

	/**
	 * Removes all extra spaces from a string
	 * @param string $sString
	 * @return string
	 */
	public static function allTrim($sString) {
		return trim(preg_replace('/\s+/m', ' ', $sString));
	}

	/**
	 * @param string $sString
	 * @return string
	 */
	public static function encodeEntities($sString) {
		return htmlentities($sString, ENT_QUOTES, 'UTF-8');
	}

	/**
	 * @param string $sUri
	 * @return string
	 */
	public static function formatUri($sUri) {
		$aReplaceWhat = array(
			'/(&([^(amp;)]))/',
			'/ {1,}/',
		);
		$aReplaceWith = array(
			'&amp;\2',
			'+',
		);

		return preg_replace($aReplaceWhat, $aReplaceWith, $sUri);
	}

	/**
	 * @param string $sString
	 * @param int $iLength
	 * @param string $sEtc
	 * @return string
	 */
	public static function truncate($sString, $iLength, $sEtc = '...') {
		if ($iLength == 0)
			return '';

		if (strlen($sString) > $iLength) {
			return substr($sString, 0, $iLength) . $sEtc;
		} else {
			return $sString;
		}
	}

	/**
	 * @param int $val
	 * @param int $base
	 * @param string $chars
	 * @return string
	 */
	public static function baseEncode($val, $base = 62, $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
		// can't handle numbers larger than 2^31-1 = 2147483647
		$str = '';
		do {
			$i = $val % $base;
			$str = $chars[$i] . $str;
			$val = ($val - $i) / $base;
		} while ($val > 0);
		return $str;
	}

	/**
	 * @param string $str
	 * @param int $base
	 * @param string $chars
	 * @return int
	 */
	public static function baseDecode($str, $base = 62, $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
		$str = (string)$str;
		$len = strlen($str);
		$val = 0;
		$arr = array_flip(str_split($chars));
		for ($i = 0; $i < $len; ++$i) {
			$val += $arr[$str[$i]] * pow($base, $len - $i - 1);
		}
		return $val;
	}
}
