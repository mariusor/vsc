<?php
/**
 * Factory class for data objects
 */
import ('exceptions');
class sqlFactory {
	static public	$TYPES 		= array ('postgresql', 'mysql', 'mysqli');
	static private	$instance	= null;

	/**
	 * returning if the set DB type is supported
	 *
	 * @param string $type
	 * @return bool
	 */
	public static function validType ($type) {
		if (in_array(strtolower($type), self::$TYPES))
			return true;
		return false;
	}

	/**
	 * returns the cuurent instance of the DB connection
	 * or a new connection of type $incString
	 *
	 * @param string $incString
	 * @return vscSqlDriverA
	 */

	static public function connect($incString, $dbHost = null, $dbUser = null, $dbPass = null) {
		if (!self::validType ($incString)) {
			self::$instance = new nullSql();
//			throw new tsExceptionUnimplemented ('The database type is invalid');
		}

		if(!(self::$instance instanceof vscSqlDriverA)) {
			if (stristr($incString, 'mysql')) {
				self::$instance =  new mySqlIm ($dbHost, $dbUser, $dbPass);
			} /*elseif (stristr ($incString, 'mysql')) {
				self::$instance =  new mySql ();
			}*/ elseif (stristr ($incString, 'postgresql')) {
				self::$instance = new postgreSql ($dbHost, $dbUser, $dbPass);
			} elseif (stristr ($incString, 'sqlserv')) {
				self::$instance = new nullSql (); // Sql server not implemented
			}

			if (self::$instance->error) {
				self::$instance = new nullSql ();
			}
		}
		return self::$instance;
	}
}
