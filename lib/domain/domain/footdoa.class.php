<?php
/**
 * the query compiler/executer object
 * @package ts_models
 * @author Marius Orcsik <marius@habarnam.ro>
 * @version 0.0.1
 */
usingPackage ('models/foo/exceptions');
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
			$sRet .= "\t" . $oColumn->getName() . ' ' . $oColumn->getType() ;
			if ($oColumn->getMaxLength()) {
				$sRet .= '(' . $oColumn->getMaxLength() . ')';
			}

			if (fooFieldInteger::isInt ($oColumn) && $oColumn->getAutoIncrement()){
				$sRet .= ' AUTO_INCREMENT'; // this needs to be replaces with Connection functionality : eg, postgres will convert integer auto_increment to serial
			}

			if (!$oColumn->getIsNullable ())
				$sRet .= ' NOT NULL';

			$sRet .= ', ' . "\n";
		}

		foreach ($oInc->getIndexes() as $oIndex) {
			// this needs to be replaced with connection functionality : something like getConstraint (type, columns)
			$sRet .=  "\t" .$oIndex->getType() . ' KEY ' . $oIndex->getName() . '  (' . $oIndex->getIndexComponents(). '),' . "\n";
		}

		$sRet = substr( $sRet, 0, -2);

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