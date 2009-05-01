<?php
/**
 * the query compiler/executer object
 * @package ts_models
 * @author Marius Orcsik <marius@habarnam.ro>
 * @version 0.0.1
 */
abstract class fooTdoA {
	/**
	 * @var fooSqlDriverA
	 */
	private $oConnection;

	/**
	 * @param fooSqlDriverA $oConnection
	 * @return void
	 */
	public function setConnection (fooSqlDriverA $oConnection) {
		$this->oConnection = $oConnection;
	}

	/**
	 * @return fooSqlDriverA
	 */
	public function getConnection () {
		if (!self::isValidConnection($this->oConnection))
			throw new fooInvalidTypeException ('Could not establish a valid DB connection - current resource type [' . get_class ($this->oConnection) . ']');
		return $this->oConnection;
	}

	/**
	 * Outputs the SQL necessary for creating the table
	 * @return string
	 */
	public function outputCreateSQL (fooEntityA $oInc) {
		$sRet = $this->getConnection()->_CREATE ($oInc->getName()) . "\n";
		$sRet .= ' ( ' . "\n";

		/* @var $oColumn fooFieldA */
		foreach ($oInc->getMembers () as $oColumn) {
			$sRet .= "\t" . $oColumn->getName() . ' ' . $oColumn->getDefinition() ;
			$sRet .= ', ' . "\n";
		}

		$aIndexes = $oInc->getIndexes(true);
		if (is_array ($aIndexes)) {
			foreach ($aIndexes as $oIndex) {
				// this needs to be replaced with connection functionality : something like getConstraint (type, columns)
				$sRet .=  "\t" . $oIndex->getDefinition() . ", \n"; //getType() . ' KEY ' . $oIndex->getName() . '  (' . $oIndex->getIndexComponents(). '), ' . "\n";
			}
		}

		$sRet = substr( $sRet, 0, -3);

		$sRet.= "\n" . ' ) ';

		if ($this->oConnection->getType() == 'mysql') {
			$sRet.= ' ENGINE ' . $this->getConnection()->getEngine();
		}

		return $sRet;
	}

	static public function isValidConnection ($oConnection) {
		return sqlFactory::validType ($oConnection->getType());
	}
}