<?php


/**
 * This class defines the structure of the 'access_control' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package Core
 * @subpackage model.map
 */
class accessControlTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'Core.accessControlTableMap';

	/**
	 * Initialize the table attributes, columns and validators
	 * Relations are not initialized by this method since they are lazy loaded
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function initialize()
	{
	  // attributes
		$this->setName('access_control');
		$this->setPhpName('accessControl');
		$this->setClassname('accessControl');
		$this->setPackage('Core');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('PARTNER_ID', 'PartnerId', 'INTEGER', true, null, null);
		$this->addColumn('NAME', 'Name', 'VARCHAR', true, 128, '');
		$this->addColumn('SYSTEM_NAME', 'SystemName', 'VARCHAR', true, 128, '');
		$this->addColumn('DESCRIPTION', 'Description', 'VARCHAR', true, 1024, '');
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('DELETED_AT', 'DeletedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('SITE_RESTRICT_TYPE', 'SiteRestrictType', 'TINYINT', false, null, null);
		$this->addColumn('SITE_RESTRICT_LIST', 'SiteRestrictList', 'VARCHAR', false, 1024, null);
		$this->addColumn('COUNTRY_RESTRICT_TYPE', 'CountryRestrictType', 'TINYINT', false, null, null);
		$this->addColumn('COUNTRY_RESTRICT_LIST', 'CountryRestrictList', 'VARCHAR', false, 1024, null);
		$this->addColumn('HS_RESTRICT_PRIVILEGE', 'HsRestrictPrivilege', 'VARCHAR', false, 20, null);
		$this->addColumn('PRV_RESTRICT_PRIVILEGE', 'PrvRestrictPrivilege', 'VARCHAR', false, 20, null);
		$this->addColumn('PRV_RESTRICT_LENGTH', 'PrvRestrictLength', 'INTEGER', false, null, null);
		$this->addColumn('KDIR_RESTRICT_TYPE', 'KdirRestrictType', 'TINYINT', false, null, null);
		$this->addColumn('CUSTOM_DATA', 'CustomData', 'LONGVARCHAR', false, null, null);
		$this->addColumn('RULES', 'Rules', 'LONGVARCHAR', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
	} // buildRelations()

} // accessControlTableMap
