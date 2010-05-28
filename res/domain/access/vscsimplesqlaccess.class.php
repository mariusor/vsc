<?php
/**
 * @package vsc_domain
 * @subpackage access
 * @author marius orcsik <marius@habarnam.ro>
 * @date 10.04.01
 */
class vscSimpleSqlAccess extends vscSimpleSqlAccessA implements vscSqlAccessI {
	/**
	 * (non-PHPdoc)
	 * @see lib/domain/access/vscSqlAccessI#save()
	 */
	public function save (vscDomainObjectI $oDomainObject) {
		$bInsert = false;
		$oPk = $oDomainObject->getPrimaryKey();
		foreach ($oPk->getFields() as $oField) {
			if (!$oField->hasValue()) {
				$bInsert = true;
				break;
			}
		}

		if ($bInsert) {
			$this->insert ($oDomainObject);
		} else {
			$this->update ($oDomainObject);
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see lib/domain/access/vscSqlAccessI#insert()
	 */
	public function insert (vscDomainObjectI $oDomainObject) {
		return $o->query($this->outputInsertSql($oDomainObject));
	}

	/**
	 * (non-PHPdoc)
	 * @see lib/domain/access/vscSqlAccessI#update()
	 */
	public function update (vscDomainObjectI $oDomainObject) {
		return $o->query($this->outputUpdateSql($oDomainObject));
	}

	/**
	 * (non-PHPdoc)
	 * @see lib/domain/access/vscSqlAccessI#delete()
	 */
	public function delete (vscDomainObjectI $oDomainObject) {
		return $o->query($this->outputDeleteSql($oDomainObject));
	}
}
