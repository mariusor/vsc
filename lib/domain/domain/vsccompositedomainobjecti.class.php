<?php
/**
 * @package vsc_domain
 * @subpackage domain
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.05.20
 */

interface vscCompositeDomainObjectI {
	/**
	 * @return vscFieldA[]
	 */
	public function getFields ();
	/**
	 * Gets the component domain objects
	 */
	public function getDomainObjects ();
	
	/**
	 * Gets the foreign key relations between the components 
	 * Alias for self::getDomainObjectRelations 
	 */
	public function getForeignKeys ();

}