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
class mySql extends vscSqlDriverA {
	public 		$conn,
				$link;
	private 	$name,
				$host,
				$user,
				$pass;

	public function __construct( $dbHost = null, $dbUser = null, $dbPass = null ){
		if (!empty ($dbHost))
			$this->host	= $dbHost;
		elseif (defined('DB_HOST'))
			$this->host	= DB_HOST;
		else
			trigger_error('Database connection data missing!', E_USER_ERROR);

		if (!empty ($dbUser))
			$this->user	= $dbUser;
		elseif (defined('DB_USER'))
			$this->user	= DB_USER;
		else
			trigger_error('Database connection data missing!', E_USER_ERROR);

		if(!empty($dbPass))
			$this->pass	= $dbPass;
		elseif (defined('DB_PASS'))
			$this->pass	= DB_PASS;
		else
			trigger_error('Database connection data missing!', E_USER_ERROR);

		if (!empty($this->host) && !empty($this->user) && !empty($this->pass)) {
			$this->connect();
		}
	}

	public function getType () {
		return vscConnectionType::mysql;
	}

	public function __destruct() {
	}

	/**
	 * wrapper for mysql_connect
	 *
	 * @return bool
	 */
	private function connect(){
		$this->link	= mysql_connect($this->host, $this->user, $this->pass);
		if(!isDBLink($this->link)) {
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

	/**
	 *
	 * @param array $incObj = array (array('field1','alias1),array('field2','alias2),...)
	 * @return unknown
	 */
	public function _SELECT($incObj){
		if (empty ($incObj))
			return '';

		$retStr = 'SELECT ';
		return $retStr.' '.$incObj.' ';
	}

	public function _CREATE(){
		return ' CREATE ';
	}

	public function _INSERT(){
		return ' INSERT ';
	}

	public function _VALUES ($incData) {
		if (empty ($incData))
			return '';
		else {
			if (is_array ($incData)) {
				$ret = implode('", "', $incData);
			}
		}

		return ' VALUES "' . $ret . '"';
	}

	public function _UPDATE($incOb){
		if (!is_array($incOb))
			$incOb[] = array ($incOb);
		return ' UPDATE `'.$incOb[0].'`'.(!empty($incOb[1]) ? ' AS `'.$incOb[1].'`' : '');
	}

	/**
	 * returns the FROM `tabl...es` part of the query
	 *
	 * @param string or array of strings $incData - table names
	 * @return string
	 */
	public function _FROM($incData){
			if (empty ($incData))
			return '';
		if (is_array($incData))
			$incData = implode('`, `',$incData);

		return ' FROM `'.$incData.'` ';
	}

	/**
	 * @return string
	 */
	public function _AND(){
		return ' AND ';
	}

	/**
	 * @return string
	 */
	public function _OR(){
		return ' OR ';
	}
	public function _JOIN ($type) {

	}

	/**
	 * @return string
	 */
	public function _AS($str){
		return ' AS '.$str;
	}

	public function _LIMIT($start, $end = 0){
//		if (!empty($start))
			return ' LIMIT '.(int)$start.(!empty($end) ? ', '.(int)$end : '');
//		return '';
	}

	/**
	 * TODO make it receive an array of tdoHabstractFields
	 * (see _SELECT)
	 *
	 * @param array of strings $colName
	 * @return string
	 */

	public function _GROUP($incObj = null){
		if (empty ($incObj))
			return '';

		$retStr = ' GROUP BY ';
		return $retStr.' '.$incObj;
	}

	public function _ORDER($orderBys = null){
		if (empty($orderBys))
			return '';
		$retStr = ' ORDER BY ';

		return $retStr.$orderBys;
	}

	public function _WHERE ($clause) {
		return ' WHERE '.$clause;
	}
}
