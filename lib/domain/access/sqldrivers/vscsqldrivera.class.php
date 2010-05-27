<?php
/**
 * Pseudo interface to be implemented (ehm, inherited) by the rest
 * of the DB classes.
 */
abstract class vscSqlDriverA extends vscObject {
	public 		$conn,
				$error,
				$link;

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
	public function __construct( $dbHost = null, $dbUser = null, $dbPass = null ) {}

	public function __destruct() {}

	private function connect() {}

	abstract public function getType ();

	public function selectDatabase($incData) {}

	public function escape ($incData) {}

	public function query($query) {}

	public function getRow () {}

	public function getAssoc () {}

	public function getArray () {}

	public function getFirst () {}

	public function close () {}

//	static public function isValid();

	abstract public function startTransaction ($bAutoCommit = false);

	abstract public function rollBackTransaction ();

	abstract public function commitTransaction ();

	abstract public function _SELECT($incObj);

	abstract public function _DELETE($sIncName);

	abstract public function _CREATE($sIncName);

	abstract public function _SET();

	abstract public function _INSERT($incOb);

	abstract public function _VALUES ($incData);

	abstract public function _UPDATE($incOb);

	abstract public function _FROM($incData);

	abstract public function _AND();

	abstract public function _OR();

	abstract public function _JOIN ($type);

	abstract public function _AS($str);

	abstract public function _LIMIT($start, $end = 0);

	abstract public function _GROUP($incObj = null);

	abstract public function _ORDER($orderBys = null);

	abstract public function _WHERE ($clause);
}