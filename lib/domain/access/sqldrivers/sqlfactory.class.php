<?php
/**
 * Factory class for data objects
 */

class sqlFactory {
	static public	$TYPES 		= array ('postgresql', 'mysql','mysqli');
	static private	$instance	= false;

	/**
	 * returning if the set DB type is supported
	 *
	 * @param string $type
	 * @return bool
	 */
	public static function validType ($type) {
		if (in_array($type, sqlFactory::$TYPES))
			return true;
		return false;
	}

	/**
	 * returns the cuurent instance of the DB connection
	 * or a new connection of type $incString
	 *
	 * @param string $incString
	 * @return interfaceSql
	 */

	static public function connect($incString) {
		if (!sqlFactory::validType ($incString)) {
			sqlFactory::$instance = new nullSql();
		}

		if(!(sqlFactory::$instance instanceof interfaceSql)) {
			if (stristr($incString, 'mysqli')) {
				sqlFactory::$instance =  new mySqlIm ();
			} elseif (stristr ($incString, 'mysql')) {
				sqlFactory::$instance =  new mySql ();
			} elseif (stristr ($incString, 'postgresql')) {
				sqlFactory::$instance = new postgreSql ();
			} elseif (stristr ($incString, 'sqlserv')) {
				sqlFactory::$instance = new nullSql (); // Sql server not implemented
			}

			if (sqlFactory::$instance->error) {
				sqlFactory::$instance = new nullSql ();
			}
		}
		return sqlFactory::$instance;
	}
}
