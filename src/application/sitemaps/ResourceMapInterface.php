<?php
/**
 * @package application
 * @subpackage sitemaps
 * @author marius orcisk <marius@habarnam.ro>
 * @date 17.01.25
 */
namespace vsc\application\sitemaps;


interface ResourceMapInterface
{
	/**
	 * @param string $sTitle
	 */
	public function setTitle($sTitle);

	/**
	 * @return string
	 */
	public function getTitle();
	/**
	 * @param array $aResources
	 */
	public function setResources($aResources);
	/**
	 * @param $sVar
	 * @param $sVal
	 * @return void
	 */
	public function addHeader($sVar, $sVal);
	/**
	 * @param $sVar
	 * @return void
	 */
	public function removeHeader($sVar);
	/**
	 * @param $sVar
	 * @param $sVal
	 * @return void
	 */
	public function addSetting($sVar, $sVal);

	/**
	 * @param string $sPath
	 * @param string $sMedia
	 */
	public function addStyle($sPath, $sMedia = 'screen');

	/**
	 * Adds a path for a JavaScript resource
	 * @param string $sPath
	 * @param bool $bInHead
	 */
	public function addScript($sPath, $bInHead = false);

	/**
	 * @param string $sType The type of the link element (eg, application/rss+xml or image/png)
	 * @param string $aData The rest of the link's attributes (href, rel, s/a)
	 * @return void
	 */
	public function addLink($sType, $aData);

	/**
	 * @param string $sName
	 * @param string $sValue
	 * @return void
	 */
	public function addMeta($sName, $sValue);

	/**
	 * @param string $sType
	 * @return array
	 */
	public function getResources($sType = null);

	/**
	 * @param null $sMedia
	 * @return array|null
	 */
	public function getStyles($sMedia = null);

	/**
	 * @param null $sName
	 * @return array|string
	 */
	public function getMetas($sName = null);

	/**
	 * @param bool $bInHead
	 * @return array
	 */
	public function getScripts($bInHead = false);

	/**
	 * @return array
	 */
	public function getSettings();

	/**
	 * @param string $sType
	 * @return array
	 */
	public function getLinks($sType = null);

	/**
	 * @param string $sVar
	 * @return array|string
	 */
	public function getSetting($sVar);

	/**
	 * @return array
	 */
	public function getHeaders();
}