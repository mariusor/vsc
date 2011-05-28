<?php
/**
 * At the moment we only have the habsql class:D, but:
 * Here should be a _PACKAGE_ to include:
 * <type>Sql - class to encapsulate the <something>sql_* functionality
 * 			 - it will be derived from interfaceSql
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
class mySql extends vscConnectionA {
	public 		$conn,
				$link;

	public function __construct( $dbHost = null, $dbUser = null, $dbPass = null ){
		if (empty ($dbHost)) {
			trigger_error('Database connection data missing!', E_USER_ERROR);
		}

		if (empty ($dbUser)) {
			trigger_error('Database connection data missing!', E_USER_ERROR);
		}

		if (!empty($dbHost) && !empty( $dbUser) && !empty($dbPass)) {
			$this->connect($dbHost, $dbUser, $dbPass);
		}
	}

	public function getType () {
		return vscConnectionType::mysql;
	}

	public function __destruct() {
	}

	static public function isValidLink ($oLink) {
		return (is_resource($oLink) && get_resource_type($oLink) == 'mysql link');
	}

	/**
	 * wrapper for mysql_connect
	 *
	 * @return bool
	 */
	private function connect($dbHost = null, $dbUser = null, $dbPass = null){
		$this->link	= mysql_connect($dbHost, $dbUser, $dbPass);
		if(!self::isValidLink($this->link)) {
			trigger_error(mysql_error(), E_USER_ERROR);
			return false;
		}
		return true;
	}

	/**
	 * wrapper for mysql_close
	 *
	 * @return bool
	 */
	public function close(){
		if(isDBLink($this->link)) {
			mysql_close($this->link);
			return true;
		}
		return false;
	}

	/**
	 * wrapper for mysql_select_db
	 *
	 * @param string $incData
	 * @return bool
	 */
	public function selectDatabase($incData){
		if (isDBLink($this->link)) {
			$this->name = $incData;
			return mysql_select_db($incData);
		} else {
			trigger_error(mysql_error(), E_USER_ERROR);
			return false;
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
			return mysql_real_escape_string($incData);
		else
			return (int)$incData;
	}

	/**
	 * wrapper for mysql_query
	 *
	 * @param string $query
	 * @return mixed
	 */
	public function query($query){
		//echo $query;
		if (!isDBLink($this->link)) {
			return false;
		}
		if (!empty($query)) {
			if (!preg_match("/insert|update|delete/i", $query))
				$this->conn = mysql_query ($query);
			echo $query.'<br/>';
		} else {
			return false;
		}
		$error = mysql_error();

		if (!empty($error))	{
			trigger_error($error.'<br/> '.$query);
			return false;
		}
		if (preg_match("/insert|update|delete/i", $query))
			return $this->conn;
		else
			return mysql_num_rows($this->conn);
	}

	/**
	 * wrapper for mysql_fetch_row
	 *
	 * @return array
	 */
	public function getRow (){
		return mysql_fetch_assoc($this->conn);
	}

	public function getAssoc (){
		//var_dump(mysql_fetch_assoc($this->conn));
		return mysql_fetch_assoc($this->conn);
	}

	/**
	 * wrapper for mysql_fetch_assoc
	 *
	 * @return array
	 */
	public function getArray (){
		$retArr = array();
		while (($r = mysql_fetch_assoc($this->conn))){
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
}
