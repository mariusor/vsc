<?php
/**
 * Factory class for data objects
 */
import ('exceptions');
class sqlFactory {
	static private	$instance	= null;

	/**
	 * returning if the set DB type is supported
	 *
	 * @param string $type
	 * @return bool
	 */
	public static function validType ($type) {
		$oReflectedSelf = new ReflectionClass('vscDbType');
		return (
			$oReflectedSelf->hasConstant($type) || // the $type is a string naming the connection type
			in_array ($type, $oReflectedSelf->getConstants())
		);
	}

	static public function getInstance ($incString, $dbHost = null, $dbUser = null, $dbPass = null, $dbName = null) {
		if (!self::validType ($incString)) {
			self::$instance = new nullSql();
			throw new vscExceptionUnimplemented ('The database type is invalid');
		}

		if(!(self::$instance instanceof vscSqlDriverA)) {
			if (is_string($incString)) {
				if (stristr($incString, 'mysql')) {
					self::$instance =  new mySqlIm ($dbHost, $dbUser, $dbPass, $dbName);
				} elseif (stristr ($incString, 'postgresql')) {
					self::$instance = new postgreSql ($dbHost, $dbUser, $dbPass, $dbName);
				} elseif (stristr ($incString, 'sqlserv')) {
					self::$instance = new nullSql (); // Sql server not implemented
				}
			} else {
				switch ($incString) {
				case vscDbType::mysql:
					self::$instance =  new mySqlIm ($dbHost, $dbUser, $dbPass, $dbName);
					break;
				case vscDbType::postgresql:
					self::$instance = new postgreSql ($dbHost, $dbUser, $dbPass, $dbName);
					break;
				case vscDbType::sqlite:
				case vscDbType::mssql:
					self::$instance = new nullSql (); // Sql server not implemented
					break;
				}
			}
		}

		if (!(self::$instance instanceof vscSqlDriverA) || self::$instance->error) {
			self::$instance = new nullSql ();
		}

		return self::$instance;
	}

	/**
	 * returns the cuurent instance of the DB connection
	 * or a new connection of type $incString
	 *
	 * @param string $incString
	 * @return vscSqlDriverA
	 */

	static public function connect($incString, $dbHost = null, $dbUser = null, $dbPass = null, $dbName = null) {
		self::getInstance($incString, $dbHost, $dbUser, $dbPass, $dbName);

		return self::$instance;
	}
}
