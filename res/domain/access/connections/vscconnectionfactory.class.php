<?php
/**
 * Factory class for data objects
 */
import ('exceptions');
class vscConnectionFactory {
	static private	$instance	= null;

	/**
	 * returning if the set DB type is supported
	 *
	 * @param string $type
	 * @return bool
	 */
	public static function validType ($iConnectionType) {
		$oReflectedSelf = new ReflectionClass('vscConnectionType');
		return in_array ($iConnectionType, $oReflectedSelf->getConstants());
	}

	static public function getInstance ($iConnectionType, $dbHost = null, $dbUser = null, $dbPass = null, $dbName = null) {
		if (!self::validType ($iConnectionType)) {
			self::$instance = new nullSql();
			throw new vscExceptionUnimplemented ('The database type is invalid');
		}

		if(!vscConnectionA::isValid(self::$instance)) {
			switch ($iConnectionType) {
			case vscConnectionType::mysql:
				self::$instance =  new mySqlIm ($dbHost, $dbUser, $dbPass, $dbName);
				break;
			case vscConnectionType::postgresql:
				self::$instance = new postgreSql ($dbHost, $dbUser, $dbPass, $dbName);
				break;
			case vscConnectionType::sqlite:
			case vscConnectionType::mssql:
				self::$instance = new nullSql (); // Sql server not implemented
				break;
			}
		}

		if (!vscConnectionA::isValid(self::$instance) || self::$instance->error) {
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
