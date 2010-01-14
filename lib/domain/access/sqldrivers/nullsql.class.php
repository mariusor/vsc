<?php
/**
 * Pseudo null to be implemented (ehm, inherited) by the rest
 * of the DB classes.
 */
class nullSql extends fooSqlDriverA {
	public 		$conn,
				$link,
				$STRING_OPEN_QUOTE = '',
				$STRING_CLOSE_QUOTE = '',
				$FIELD_OPEN_QUOTE = '',
				$FIELD_CLOSE_QUOTE = '',
				$TRUE = '',
				$FALSE = '';

	/**
	 * just a function to trigger an error in the eventuality of using
	 * an unsupported DB_TYPE connection (usually because of a config error)
	 *
	 * TODO: this can be done more elegantly using an exception in the
	 * 		 sqlFactory class
	 *
	 * @param string $dbHost
	 * @param string $dbUser
	 * @param string $dbPass
	 */
	public function __construct( $dbHost = null, $dbUser = null, $dbPass = null ) {
		throw new tsExceptionUnimplemented('This site has all database functionality disabled.<br/> Please check for configuration errors');
	}

	public function getType () {
		return 'null';
	}

	public function close () {}

	public function getScalar () {}

	public function startTransaction ($bAutoCommit = false) {}

	public function rollBackTransaction () {}

	public function commitTransaction () {}

	public function _SELECT ($incObj){}

	public function _CREATE ($sIncName){}

	public function _SET(){}

	public function _INSERT ($incData){}

	public function _VALUES ($incData) {}

	public function _UPDATE ($incOb){}

	public function _FROM ($incData){}

	public function _AND (){}

	public function _OR (){}

	public function _JOIN ($type) {}

	public function _AS ($str){}

	public function _LIMIT ($start, $end = 0){}

	public function _GROUP ($incObj = null){}

	public function _ORDER ($orderBys = null){}

	public function _WHERE ($clause) {}
}
