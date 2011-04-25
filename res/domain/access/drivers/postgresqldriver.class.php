<?php
class postgreSQLDriver extends SQLGenericDriver {
	public $STRING_OPEN_QUOTE = '\'',
		$STRING_CLOSE_QUOTE = '\'',
		$FIELD_OPEN_QUOTE = '"',
		$FIELD_CLOSE_QUOTE = '"',
		$TRUE = 'true',
		$FALSE = 'false';


	/**
	 *
	 * @param array $incObj = array (array('field1','alias1),array('field2','alias2),...)
	 * @return unknown
	 */
	public function _SELECT ($incObj){
		if (empty ($incObj)) {
			return '';
		}

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
		if (empty ($incData)) {
			return '';
		}
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
		if (empty ($incData)) {
			return '';
		}
		if (is_array($incData)) {
			$incData = implode('", "',$incData);
		}

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
		if (!empty($end)) {
			return ' LIMIT '.(int)$start . ', '.(int)$end;
		} elseif (!empty ($start)) {
			return ' LIMIT '.(int)$start;
		} else {
			return '';
		}
	}

	/**
	 * TODO make it receive an array of tdoHabstractFields
	 * (see _SELECT)
	 *
	 * @param array of strings $colName
	 * @return string
	 */
	public function _GROUP ($incObj = null){
		if (empty ($incObj)) {
			return '';
		}

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
		if (empty($orderBys)) {
			return '';
		}
		$retStr = ' ORDER BY ';

		return $retStr.$orderBys;
	}

	public function _WHERE ($clause) {
		return ' WHERE ' . $clause;
	}

	public function _NULL ($bIsNull = true) {
		return (!$bIsNull ? ' NOT ' : ' ') . 'NULL';
	}
}