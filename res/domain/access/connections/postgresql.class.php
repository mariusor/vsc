<?php
class postgreSql extends vscSqlDriverA {
	public 		$conn,
				$link,
				$STRING_OPEN_QUOTE = '\'',
				$STRING_CLOSE_QUOTE = '\'',
				$FIELD_OPEN_QUOTE = '"',
				$FIELD_CLOSE_QUOTE = '"',
				$TRUE = 'true',
				$FALSE = 'false';
	private 	$name,
				$host,
				$user,
				$pass;

	static public function isValid ($oLink) {
		return true;// ($oLink instanceof mysqli);
	}

	public function __construct( $dbHost = null, $dbUser = null, $dbPass = null , $dbName = null ){
		if (!extension_loaded('pgsql')) {
			return new nullSql();
		}
		if (!empty ($dbHost)) {
			$this->host	= $dbHost;
		} else {
			throw new vscConnectionException ('Database connection data missing: [DB_HOST]');
		}

		if (!empty ($dbUser)) {
			$this->user	= $dbUser;
		} else {
			throw new vscConnectionException ('Database connection data missing: [DB_USERNAME]');
		}

		if(!empty($dbPass)) {
			$this->pass	= $dbPass;
		}

		try {
			$this->connect ();
		} catch (Exception $e) {
			d($e);
		}
	}

	public function getType () {
		return vscDbType::postgresql;
	}


	/**
	 * wrapper for pg_connect
	 *
	 * @return bool
	 */
	private function connect () {
		try {
			$this->link	= pg_connect('host='.$this->host.' user='.$this->user.' password='.$this->pass . (!empty ($this->name) ? 'dbname='.$this->name : '' ));
		} catch (ErrorException $e) {
			$this->error = $e->getMessage();
			trigger_error ($this->link->error, E_USER_ERROR);
		}
		if ($this->link) {
			$err = pg_last_error($this->link);
			if ($err) {
				$this->error = $err;
				trigger_error ($this->link->error, E_USER_ERROR);
				return false;
			}
		}
		return true;
	}

	/**
	 * wrapper for pg_close
	 *
	 * @return bool
	 */
	public function close (){
//		if ($this->link instanceof mysqli)
		pg_close($this->link);
		$this->link = null;
		return true;
	}

	/**
	 * @param string $incData
	 * @return bool
	 */
	public function selectDatabase ($incData){
		// in postgres we don't quite need it as pg_connect handles it
		return true;
	}

	/**
	 * wrapper for pg_escape_string
	 *
	 * @param mixed $incData
	 * @return mixed
	 */
	public function escape ($incData){
		// so far no escaping on BYTEA fields
		// also there's a problem with the fact that I use tdoAbstract->escape
		// to enclose values in quotes for MySQL
		// TODO - this fracks up the postgres stuff
		if (is_string($incData))
			return pg_escape_string ($this->link, $incData);
		elseif (is_numeric ($incData))
			return (int)$incData;
	}

	/**
	 * wrapper for mysql_query
	 *
	 * @param string $query
	 * @return mixed
	 */
	public function query ($query){
		if (pg_connection_status($this->link) !== PGSQL_CONNECTION_OK) {
			return false;
		}
		if (!empty($query)) {
			$qst = microtime(true);
			$this->conn = pg_query($this->link, $query);
			$qend = microtime(true);
			if (!isset($GLOBALS['queries'])) {
				$GLOBALS['queries'] = array ();
			}
			if (isset($GLOBALS['queries'])) {
				$aQuery = array (
					'query'	=> $query,
					'duration' => $qend - $qst, // seconds
				);

				$GLOBALS['queries'][] = $aQuery;
			}
		} else
			return false;

		if (!$this->conn)	{
			$e = new vscExceptionDomain($this->link->error.'<br/> ' . $query, $this->link->errno);
			return false;
		}

		if (stristr('select', $query))
			// mysqli result
			return $this->conn;
		elseif ( preg_match('/insert|update|replace|delete/i', $query) )
			return pg_affected_rows ($this->conn);
	}

	/**
	 * wrapper for mysql_fetch_row
	 *
	 * @return array
	 */
	public function getRow (){
		if ($this->conn)
			return pg_fetch_row ($this->conn);
	}

	// FIXME: for some reason the getAssoc and getArray work differently
	public function getAssoc () {
		if ($this->conn)
			return pg_fetch_assoc ($this->conn);
	}

	/**
	 * wrapper for mysql_fetch_row
	 *
	 * @return array
	 */
	public function getObjects () {
		// pg_??
		$retArr = array ();
//		$i = 0;
//		if ($this->conn && $this->link) {
//			while ($i < mysqli_field_count ($this->link)) {
//				$t = $this->conn->fetch_field_direct ($i++);
//				$retArr[] = $t;
//			}
//		}

		return $retArr;
	}

	/**
	 * wrapper for mysql_fetch_assoc
	 *
	 * @return array
	 */
	public function getArray (){
		$retArr = array();
		if ($this->conn)
			while ( ($r = pg_fetch_assoc ($this->conn)) ){
				$retArr[] = $r;
			}

		return $retArr;
	}

	/**
	 * getting the first result in the resultset
	 *
	 * @return mixed
	 */
	public function getScalar() {
		$retVal = $this->getRow();
		if (is_array($retVal))
			$retVal = current($retVal);
		return $retVal;
	}


	public function startTransaction ($bAutoCommit = false) {
		throw new vscExceptionUnimplemented('Transaction support for postgres is not currenty implemented');
	}

	public function rollBackTransaction () {
		throw new vscExceptionUnimplemented('Transaction support for postgres is not currenty implemented');
	}

	public function commitTransaction () {
		throw new vscExceptionUnimplemented('Transaction support for postgres is not currenty implemented');
	}

	/**
	 *
	 * @param array $incObj = array (array('field1','alias1),array('field2','alias2),...)
	 * @return unknown
	 */
	public function _SELECT ($incObj){
		if (empty ($incObj))
			return '';

		$retStr = 'SELECT ';
		return $retStr.' '.$incObj.' ';
	}

	public function _DELETE($sIncName) {
		return ' DELETE FROM ' . $sIncName . ' ';
	}

	public function _CREATE ($sIncName){
		return ' CREATE TABLE ' . $sIncName;
	}

	public function _SET(){
		return ' ';
	}

	public function _INSERT ($incData){
		if (empty ($incData))
			return '';
		return ' INSERT INTO ' . $incData;
	}

	public function _VALUES ($incData) {
		return ' VALUES ' . $incData;
	}

	public function _UPDATE ($sTable){
		return ' UPDATE '. $sTable;
	}

	/**
	 * returns the FROM tabl...es part of the query
	 *
	 * @param string or array of strings $incData - table names
	 * @return string
	 */
	public function _FROM ($incData){
		if (empty ($incData))
			return '';
		if (is_array($incData))
			$incData = implode('", "',$incData);

		return ' FROM '.$incData.' ';
	}

	/**
	 * @return string
	 */
	public function _AND (){
		return ' AND ';
	}

	/**
	 * @return string
	 */
	public function _OR (){
		return ' OR ';
	}
	public function _JOIN ($type) {

	}

	/**
	 * @return string
	 */
	public function _AS ($str){
		return ' AS ' . $str;
	}

	public function _LIMIT ($start, $end = 0){
		if (!empty($end))
			return ' LIMIT '.(int)$start . ', '.(int)$end;
		elseif (!empty ($start))
			 return ' LIMIT '.(int)$start;
		else
			return '';
	}

	/**
	 * TODO make it receive an array of tdoHabstractFields
	 * (see _SELECT)
	 *
	 * @param array of strings $colName
	 * @return string
	 */
	public function _GROUP ($incObj = null){
		if (empty ($incObj))
			return '';

		$retStr = ' GROUP BY ';
		return $retStr . ' ' . $incObj;
	}

	/**
	 * method that abstracts the ORDER BY clauses
	 *
	 * @param 	string $orderBys
	 * @return	string
	 */
	public function _ORDER ($orderBys = null){

		if (empty($orderBys))
			return '';
		$retStr = ' ORDER BY ';

		return $retStr.$orderBys;
	}

	public function _WHERE ($clause) {
		return ' WHERE '.$clause;
	}

	public function _NULL ($bIsNull = true) {
		return (!$bIsNull ? ' NOT ' : ' ') . 'NULL';
	}
}
