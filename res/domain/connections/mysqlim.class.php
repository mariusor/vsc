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
class mySqlIm extends vscConnectionA {
	/**
	 * @var mysqli_result
	 */
	public 		$conn;

	/**
	 * @var mysqli
	 */
	public		$link;
	private 	$name,
				$host,
				$user,
				$pass,
				$iLastInsertId;

	private		$defaultSocketPath =  '/var/run/mysqld/mysqld.sock';

	static public function isValidLink ($oLink) {
		return ($oLink instanceof mysqli);
	}

	public function __construct( $dbHost = null, $dbUser = null, $dbPass = null, $dbName = null ){
		if (!extension_loaded('mysqli')) {
			//return new nullSql();
			throw new vscExceptionConnection ('Database engine missing: mysqlim');
		}
		if (!empty ($dbHost)) {
			$this->host	= $dbHost;
		} else {

		}

		if (!empty ($dbUser)) {
			$this->user	= $dbUser;
		} else {
			throw new vscExceptionConnection ('Database connection data missing: [DB_USERNAME]');
		}

		if(!empty($dbPass)) {
			$this->pass	= $dbPass;
		}

		try {
			$this->connect ();
		} catch (vscExceptionConnection $e) {
			throw $e;
		} catch (Exception $e) {
			// d($e);
		}
	}

	public function getEngine () {
		return 'InnoDB';
	}

	public function getType () {
		return vscConnectionType::mysql;
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
			throw new vscExceptionConnection('mysqli : ' . $this->error);
		}
		return true;
	}

	/**
	 * wrapper for mysql_close
	 *
	 * @return bool
	 */
	public function close (){
		if (self::isValidLink($this->link))
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
		if (self::isValidLink($this->link) && $this->link->select_db($incData)) {
			return true;
		} else {
			throw new vscExceptionConnection($this->link->error . ' ['.$this->link->errno . ']');
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

	public function getLastInsertId() {
		return $this->iLastInsertId;
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
			$this->conn = $this->link->query($query);
			$qend = microtime(true);
		} else
			return false;

		if ($this->link->errno)	{
			throw new vscExceptionConnection ($this->link->error. vscString::nl() . $query . vscString::nl ());
			return false;
		}

		$iReturn =  $this->link->affected_rows;

		if (isset($GLOBALS['vsc::queries'])) {
			$aQuery = array (
				'query'		=> $query,
				'duration'	=> $qend - $qst,  // seconds
				'num_rows'	=> is_numeric($iReturn) ? $iReturn : 0
			);

			$GLOBALS['vsc::queries'][] = $aQuery;
		}

		if (stristr ($query, 'insert')) {
			$this->conn = $this->link->query('select last_insert_id();');
			$this->iLastInsertId = $this->getScalar();
		}

		return $iReturn;
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
		if (
			$this->conn instanceof mysqli_result
		) {
			return $this->conn->fetch_assoc();
		}
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
