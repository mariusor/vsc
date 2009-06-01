<?php
/**
 * Factory class for data objects
 */
usingPackage ('coreexceptions');
class sqlFactory {
	static public	$TYPES 		= array ('postgresql', 'mysql', 'mysqli', 'null');
	static private	$instance	= false;

	/**
	 * returning if the set DB type is supported
	 *
	 * @param string $type
	 * @return bool
	 */
	public static function validType ($type) {
		if (in_array(strtolower($type), sqlFactory::$TYPES))
			return true;
		return false;
	}

	/**
	 * returns the cuurent instance of the DB connection
	 * or a new connection of type $incString
	 *
	 * @param string $incString
	 * @return fooSqlDriverA
	 */

	static public function &connect($incString) {
		if (!sqlFactory::validType ($incString)) {
			sqlFactory::$instance = new nullSql();
//			throw new tsExceptionUnimplemented ('The database type is invalid');
		}

		if(!(sqlFactory::$instance instanceof fooSqlDriverA)) {
			if (stristr($incString, 'mysql')) {
				sqlFactory::$instance =  new mySqlIm ();
			} /*elseif (stristr ($incString, 'mysql')) {
				sqlFactory::$instance =  new mySql ();
			}*/ elseif (stristr ($incString, 'postgresql')) {
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
