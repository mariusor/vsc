<?php
namespace mocks\infrastructure\urls;

use vsc\infrastructure\urls\UrlParserA;

class UrlParserFixture extends UrlParserA {

	public static function parse_url ($sUrl = null) {
		return parent::parse_url($sUrl);
	}

	public static function makeQuery ($aQueryComponents) {
		$sQuery = '';
		if (count($aQueryComponents) >= 1) {
			$aQuery = array();
			foreach ($aQueryComponents as $key => $val) {
				$aQuery[] = $key . '=' . $val;
			}
			$sQuery = implode('&', $aQuery);
		}
		return $sQuery;
	}

	public static function makeUrl ($aUrlComponents) {
		$sUrl = '';
		if (!empty ($aUrlComponents['scheme'])) {
			$sUrl .= $aUrlComponents['scheme'] . '://';
		}
		if (!empty ($aUrlComponents['host'])) {
			if (!empty ($aUrlComponents['user']) ) {
				$sUrl .= $aUrlComponents['user'];
				if (!empty ($aUrlComponents['pass']) ) {
					$sUrl .= ':' . $aUrlComponents['pass'];
				}
				$sUrl .= '@';
			}
			$sUrl .= $aUrlComponents['host'];
		}
		if (!empty ($aUrlComponents['path'] )) {
			$sUrl .= $aUrlComponents['path'];
		}
		$sQuery = self::makeQuery($aUrlComponents['query']);
		if (!empty ($sQuery)) {
			$sUrl .= '?' . $sQuery;
		}
		if (!empty($aUrlComponents['fragment'])) {

			$sUrl .= '#' . $aUrlComponents['fragment'];
		}
		return $sUrl;
	}

}
