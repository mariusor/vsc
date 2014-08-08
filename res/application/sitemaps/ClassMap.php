<?php
/**
 * @package vsc\application\sitemaps
 * @author marius orcisk <marius@habarnam.ro>
 * @date 2014.08.07
 */
namespace vsc\application\sitemaps;


use vsc\application\processors\ProcessorA;

class ClassMap extends MappingA {

	/**
	 * @var Object
	 */
//	private $oPayload;

	public function __construct ($sPath, $sRegex) {
		parent::__construct($sPath, $sRegex);
//		$this->oProcessor	= new $sPath();
	}
}
