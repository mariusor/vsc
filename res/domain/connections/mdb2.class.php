<?php
/**
 * Yo dawg I heard you like wrappers
 * so I put a wrapper for the MDB2 wrapper
 * @package ts_model
 * @subpackage connections
 * @author Marius Orcsik <marius@habarnam.ro>
 * @date 09.04.27
 */
class mdb2 extends vscConnectionA {
	public 		$conn,
				$link;
	private 	$name,
				$host,
				$user,
				$pass;

	public function isLoadable () {
		return extension_loaded('mdb2');
	}

	public function getType () {
		return null;
	}

	public function __construct( $dbHost = null, $dbUser = null, $dbPass = null ){
		if ($this->isLoadable()) {
			return new nullSql();
		}

		if (!empty ($dbHost))
			$this->host	= $dbHost;
		elseif (defined('DB_HOST'))
			$this->host	= DB_HOST;
		else
			throw new vscConnectionException ('Database connection data missing: [DB_HOST]');

		if (!empty ($dbUser))
			$this->user	= $dbUser;
		elseif (defined('DB_USER'))
			$this->user	= DB_USER;
		else
			throw new vscConnectionException ('Database connection data missing: [DB_USERNAME]');

		if(!empty($dbPass))
			$this->pass	= $dbPass;
		elseif (defined('DB_PASS'))
			$this->pass	= DB_PASS;
		else
			throw new vscConnectionException ('Database connection data missing [DB_PASSWORD]');

		if (!empty($this->host) && !empty($this->user) && !empty($this->pass)) {
			$this->connect ();
		}
	}

	public function __destruct() {
//		var_dump($this->link);
//		if (!empty ($this->link) &&  $this->link  instanceof mysqli)
//			$this->close();
	}


	/**
	 * wrapper for mysql_connect
	 *
	 * @return bool
	 */
	private function connect (){
		$this->link	= @new mysqli ($this->host, $this->user, $this->pass);
		$errNo = mysqli_connect_errno();
		if (!empty($errNo)) {
			$this->error = $errNo.' '.mysqli_connect_error();
			throw new vscConnectionException($this->error);
//			trigger_error ($this->link->error, E_USER_ERROR);
			return false;
		}
		return true;
	}

	/**
	 * wrapper for mysql_close
	 *
	 * @return bool
	 */
	public function close (){
		if ($this->link instanceof mysqli)
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
		if (($this->link instanceof mysqli) && $this->link->select_db($incData)) {
			return true;
		} else {
//			trigger_error($this->link->error, E_USER_ERROR);
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
			echo htmlentities ($query).' ['.number_format($qend-$qst, 5, ',', '.').'s]<br/>'."\n";
			if (isset($GLOBALS['qCnt']))
				$GLOBALS['qCnt']++;
		} else
			return false;

		if ($this->link->errno)	{
			trigger_error ($this->link->error.'<br/> '.$query);
			return false;
		}

		if (stristr('select', $query))
			// mysqli result
			return $this->conn;
		elseif (preg_match('/insert|update|replace|delete/i', $query))
			return $this->link->affected_rows;
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
		if ($this->conn instanceof mysqli_result)
			while (($r = $this->conn->fetch_assoc ())){
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
}
