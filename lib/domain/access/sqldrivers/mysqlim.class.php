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

class mySqlIm extends fooSqlDriverA {
	public 		$conn,
				$link,
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

	public function __construct( $dbHost = null, $dbUser = null, $dbPass = null ){
		if (!extension_loaded('mysqli')) {
			return new nullSql();
		}
		if (!empty ($dbHost))
			$this->host	= $dbHost;
		elseif (defined('DB_HOST'))
			$this->host	= DB_HOST;
		else
			throw new tsExceptionModel ('Database connection data missing: [DB_HOST]');

		if (!empty ($dbUser))
			$this->user	= $dbUser;
		elseif (defined('DB_USER'))
			$this->user	= DB_USER;
		else
			throw new tsExceptionModel ('Database connection data missing: [DB_USERNAME]');

		if(!empty($dbPass))
			$this->pass	= $dbPass;
		elseif (defined('DB_PASS'))
			$this->pass	= DB_PASS;
		else
			throw new tsExceptionModel ('Database connection data missing [DB_PASSWORD]');

		if (!empty($this->host) && !empty($this->user) && !empty($this->pass)) {
			$this->connect ();
		}
	}

	public function getEngine () {
		return 'INNODB';
	}

	public function getType () {
		return 'mysql';
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
			throw new tsExceptionModel($this->error);
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

	public function _CREATE ($sName){
		return ' CREATE ' . $sName . ' ';
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
		if (empty ($incData))
			return '';
		else {
			if (is_array ($incData)) {
				$ret = '';
				foreach ($incData as $value) {
					if (is_numeric($value))
						$ret .= $value . ', ';
					elseif (is_string($value))
						$ret .= "'" . $this->escape ($value) . "', ";
				}
				$ret = substr ($ret,0, -2);
			} elseif (is_string ($incData)) {
				$ret = $incData;
			}
		}
		return ' VALUES (' . $ret . ' )';
	}

	public function _UPDATE ($incOb){
		if (!is_array($incOb))
			$incOb[] = array ($incOb);
		return ' UPDATE '.$incOb[0].(!empty($incOb[1]) ? ' AS '.$incOb[1] : '');
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
}
