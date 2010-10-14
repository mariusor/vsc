<?php
/**
 * At the moment we only have the habsql class:D, but:
 * Here should be a _PACKAGE_ to include:
 * <type>Sql - class to encapsulate the <something>sql_* functionality
 * 			 - it will be derived from tdoHabstract
 * <type>SqlR - the sql resource of type <type> [might not be needed]
 * 			   - in case I need it, <type>Sql->conn will have this type
 * <type>SqlOrder - a struct(class, yeah, yeah) to contain the ORDER BY
 * 					pairs of stuff: string $field, bool $ASC = true
 * <type>SqlJoin - class to handle joining of two <type>Sql classes
 * 				  - TODO: very important
 * <type>SqlField
 *
 * OBS: maybe the static methods (_AND, _OR, sa.) can be conained into
 *  an external object. (??!)
 */
class mySqlIm extends vscSqlDriverA {
	public 		$conn;

	/**
	 * @var mysqli
	 */
	public		$link,
				$STRING_OPEN_QUOTE = '"',
				$STRING_CLOSE_QUOTE = '"',
				$FIELD_OPEN_QUOTE = '`',
				$FIELD_CLOSE_QUOTE = '`',
				$TRUE = '1',
				$FALSE = '0';
	private 	$name,
				$host,
				$user,
				$pass;

	private		$defaultSocketPath =  '/var/run/mysqld/mysqld.sock';

	static public function isValid ($oLink) {
		return ($oLink instanceof mysqli);
	}


	public function __construct( $dbHost = null, $dbUser = null, $dbPass = null, $dbName = null ){
		if (!extension_loaded('mysqli')) {
			//return new nullSql();
			throw new vscConnectionException ('Database engine missing: mysqlim');
		}
		if (!empty ($dbHost)) {
			$this->host	= $dbHost;
		} else {

		}

		if (!empty ($dbUser)) {
			$this->user	= $dbUser;
		} else {
			throw new vscConnectionException ('Database connection data missing: [DB_USERNAME]');
		}

		if(!empty($dbPass)) {
			$this->pass	= $dbPass;
		}

//		try {
			$this->connect ();
//		} catch (Exception $e) {
//			d($e);
//		}
	}

	public function getEngine () {
		return 'InnoDB';
	}

	public function getType () {
		return vscDbType::mysql;
	}

	public function startTransaction ($bAutoCommit = false) {
		if ($this->getEngine() != 'InnoDB')
			throw new vscExceptionUnimplemented ('Unable to use transactions for the current MySQL engine ['.$this->getEngine().'].');

		$sQuery = 'SET autocommit=' . ($bAutoCommit ? 1 : 0) . ';';
		$this->query($sQuery);
		$sQuery = 'START TRANSACTION;';
		return $this->query($sQuery);
	}

	public function rollBackTransaction () {
		if ($this->getEngine() != 'InnoDB')
			throw new vscExceptionUnimplemented ('Unable to use transactions for the current MySQL engine ['.$this->getEngine().'].');

		$sQuery = 'ROLLBACK;';
		return $this->query($sQuery);
	}

	public function commitTransaction () {
		if ($this->getEngine() != 'InnoDB')
			throw new vscExceptionUnimplemented ('Unable to use transactions for the current MySQL engine ['.$this->getEngine().'].');

		$sQuery = 'COMMIT;';
		return $this->query($sQuery);
	}

	/**
	 * wrapper for mysql_connect
	 *
	 * @return bool
	 */
	private function connect () {
		$this->link	= new mysqli ($this->host, $this->user, $this->pass, $this->name, null, $this->defaultSocketPath);
		if (!empty($this->link->connect_errno)) {
			$this->error = $this->link->connect_errno . ' ' . $this->link->connect_error;
			throw new vscConnectionException('mysqli : ' . $this->error);
		}
		return true;
	}

	/**
	 * wrapper for mysql_close
	 *
	 * @return bool
	 */
	public function close (){
		if (self::isValid($this->link))
			$this->link->close ();
		// dunno how smart it is to nullify an mysqli object
		$this->link = null;
		return true;
	}

	/**
	 * wrapper for mysql_select_db
	 *
	 * @param string $incData
	 * @return bool
	 */
	public function selectDatabase ($incData){
		$this->name = $incData;
		if (self::isValid($this->link) && $this->link->select_db($incData)) {
			return true;
		} else {
			throw new vscConnectionException($this->link->error . ' ['.$this->link->errno . ']');
		}
	}

	/**
	 * wrapper for mysql_real_escape_string
	 *
	 * @param mixed $incData
	 * @return mixed
	 */
	public function escape ($incData){
		if (is_string($incData))
			return $this->link->escape_string($incData);
		else
			return $incData;
	}

	/**
	 * wrapper for mysql_query
	 *
	 * @param string $query
	 * @return mixed
	 */
	public function query ($query){
		if (!($this->link instanceof mysqli)) {
			return false;
		}
		if (!empty($query)) {
			$qst = microtime(true);
//			if (!preg_match("/insert|update|delete/i", $query))
			$this->conn = $this->link->query($query);
			$qend = microtime(true);
			if (!isset($GLOBALS['queries'])) {
				$GLOBALS['queries'] = array ();
			}
			if (isset($GLOBALS['queries'])) {
				$aQuery = array (
					'query'	=> $query,
					'duration' => $qend - $qst,  // seconds
				);

				$GLOBALS['queries'][] = $aQuery;
			}
		} else
			return false;

		if ($this->link->errno)	{
			throw new vscConnectionException ($this->link->error. vsc::nl() . $query . vsc::nl ());
			return false;
		}

		if (stristr($query, 'select')) {
			// mysqli result
			return $this->conn;
		} elseif (preg_match('/insert|update|replace|delete/i', $query)) {
			return $this->link->affected_rows;
		}
		return true;
	}

	/**
	 * wrapper for mysql_fetch_row
	 *
	 * @return array
	 */
	public function getRow (){
		if ($this->conn instanceof mysqli_result)
			return $this->conn->fetch_row ();
	}

	// FIXME: for some reason the getAssoc and getArray work differently
	public function getAssoc () {
		if ($this->conn instanceof mysqli_result)
			return $this->conn->fetch_assoc ();
	}

	/**
	 * wrapper for mysql_fetch_row
	 *
	 * @return array
	 */
	public function getObjects () {
		$retArr = array ();
		$i = 0;
		if ($this->conn instanceof mysqli_result && $this->link instanceof mysqli ) {
			while ($i < mysqli_field_count ($this->link)) {
				$t = $this->conn->fetch_field_direct ($i++);
				$retArr[] = $t;
			}
		}

		return $retArr;
	}

	/**
	 * wrapper for mysql_fetch_assoc
	 *
	 * @return array
	 */
	public function getArray (){
		$retArr = array();
		if ($this->conn instanceof mysqli_result) {
			while ($r =$this->conn->fetch_assoc ()){
				$retArr[] = $r;
			}
			$this->conn->free_result();
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

	/**
	 *
	 * @param array $incObj = array (array('field1','alias1),array('field2','alias2),...)
	 * @return unknown
	 */
	public function _SELECT ($incObj){
		if (empty ($incObj))
			return '';

		$retStr = 'SELECT ';
		return $retStr . ' ' . $incObj . ' ';
	}

	public function _DELETE($sIncName) {
		return ' DELETE FROM ' . $sIncName . ' ';
	}

	public function _CREATE ($sName){
		return ' CREATE TABLE ' . $sName . ' ';
	}

	public function _SET(){
		return ' SET ';
	}

	public function _INSERT ($incData){
		if (empty ($incData))
			return '';
		return ' INSERT INTO '.$incData . ' ';
	}

	public function _VALUES ($incData) {
//		if (empty ($incData))
//			return '';
//		else {
//			if (is_array ($incData)) {
//				$ret = '';
//				foreach ($incData as $value) {
//					if (is_numeric($value))
//						$ret .= $value . ', ';
//					elseif (is_string($value))
//						$ret .= "'" . $this->escape ($value) . "', ";
//				}
//				$ret = substr ($ret,0, -2);
//			} elseif (is_string ($incData)) {
//				$ret = $incData;
//			}
//		}
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
			$incData = implode(', ',$incData);

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
		return $type . ' JOIN ';
	}

	/**
	 * @return string
	 */
	public function _AS ($str){
		return ' AS '.$str;
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
		return $retStr.' '.$incObj;
	}

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
