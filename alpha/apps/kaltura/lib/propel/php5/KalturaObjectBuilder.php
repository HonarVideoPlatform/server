<?php
/**
 * @package server-infra
 * @subpackage propel
 */
require_once 'propel/engine/builder/om/php5/PHP5ObjectBuilder.php';

/**
 * Generates a PHP5 base Object class for user object model (OM).
 *
 * This class produces the base object class (e.g. BaseMyTable) which contains all
 * the custom-built accessor and setter methods.
 *
 * @package server-infra
 * @subpackage propel
 */
class KalturaObjectBuilder extends PHP5ObjectBuilder
{
	const KALTURA_COLUMN_CREATED_AT = 'created_at';
	const KALTURA_COLUMN_UPDATED_AT = 'updated_at';
	const KALTURA_COLUMN_CUSTOM_DATA = 'custom_data';
	
	protected static $systemColumns = array(
		self::KALTURA_COLUMN_CREATED_AT,
		self::KALTURA_COLUMN_UPDATED_AT,
		self::KALTURA_COLUMN_CUSTOM_DATA,
	);

	/* (non-PHPdoc)
	 * @see PHP5ObjectBuilder::addClassOpen($script)
	 */
	protected function addClassOpen(&$script)
	{
		$table = $this->getTable();
		$tableName = $table->getName();
		$tableDesc = $table->getDescription();
		$interface = $this->getInterface();

		$script .= "
/**
 * Base class that represents a row from the '$tableName' table.
 *
 * $tableDesc
 *";
		if ($this->getBuildProperty('addTimeStamp')) {
			$now = strftime('%c');
			$script .= "
 * This class was autogenerated by Propel " . $this->getBuildProperty('version') . " on:
 *
 * $now
 *";
		}
		$script .= "
 * @package ".$this->getPackage()."
 * @subpackage ".$this->getSubpackage()."
 */
abstract class ".$this->getClassname()." extends ".ClassTools::classname($this->getBaseClass())." ";

		$interface = ClassTools::getInterface($table);
		if ($interface) {
			$script .= " implements " . ClassTools::classname($interface);
		}

		$script .= " {

";
	}

	/* (non-PHPdoc)
	 * @see OMBuilder::getClassFilePath()
	 */
	public function getClassFilePath()
	{
		return ClassTools::getFilePath('lib.model.om', $this->getClassname());
	}

	/* (non-PHPdoc)
	 * @see PHP5ObjectBuilder::getPackage()
	 */
	public function getPackage()
	{
		$pkg = ($this->getTable()->getPackage() ? $this->getTable()->getPackage() : $this->getDatabase()->getPackage());
		if (!$pkg) {
			$pkg = $this->getBuildProperty('targetPackage');
		}
		return $pkg;
	}
	
	public function shouldRaiseEvents()
	{
		return ($this->getTable()->getAttribute('raiseEvents', 'true') == 'true');
	}
	
	public function isDeletable()
	{
		return ($this->getTable()->getAttribute('deletable', 'false') == 'true');
	}
	
	public function getSubpackage()
	{
		$pkg = $this->getBuildProperty('subpackage');
		return "$pkg.om";
	}
	
	/**
	 * Adds class attributes.
	 * @param      string &$script The script will be modified in this method.
	 */
	protected function addAttributes(&$script)
	{
		parent::addAttributes($script);
		
		$this->addTraceAttributes($script);
	}

	/**
	 * Adds the $alreadyInValidation attribute, which prevents attempting to re-validate the same object.
	 * @param      string &$script The script will be modified in this method.
	 */
	protected function addTraceAttributes(&$script)
	{
		$script .= "
	/**
	 * Store columns old values before the changes
	 * @var        array
	 */
	protected \$oldColumnsValues = array();
	
	/**
	 * @return array
	 */
	public function getColumnsOldValues()
	{
		return \$this->oldColumnsValues;
	}
	
	/**
	 * @return mixed field value or null
	 */
	public function getColumnsOldValue(\$name)
	{
		if(isset(\$this->oldColumnsValues[\$name]))
			return \$this->oldColumnsValues[\$name];
			
		return null;
	}
";
	}
	
	/**
	 * Adds the methods related to refreshing, saving and deleting the object.
	 * @param      string &$script The script will be modified in this method.
	 */
	protected function addManipulationMethods(&$script)
	{
		parent::addManipulationMethods($script);
		
		$this->addSaveHooks($script);
	}
	
	protected function addReload(&$script)
	{
		$parentReload = '';
		parent::addReload($parentReload);
		
		// disable default criteria during the call to doSelectStmt
		$doSelectStmt = "\$stmt = ".$this->getPeerClassname()."::doSelectStmt(\$this->buildPkeyCriteria(), \$con);";
		$doSelectPos = strpos($parentReload, $doSelectStmt);
		
		if ($doSelectPos === false)
		{
			throw new EngineException("Unexpected: could not find the call to doSelectStmt in reload function");
		}
		
		$newLine = "\n\t\t";
		
		$script .= 
			substr($parentReload, 0, $doSelectPos) .
			$this->getPeerClassname() . "::setUseCriteriaFilter(false);" . $newLine .
			"\$criteria = \$this->buildPkeyCriteria();" . $newLine .
			$this->getPeerClassname() . "::addSelectColumns(\$criteria);" . $newLine .
			"\$stmt = BasePeer::doSelect(\$criteria, \$con);" . $newLine . 
			$this->getPeerClassname() . "::setUseCriteriaFilter(true);" .
			substr($parentReload, $doSelectPos + strlen($doSelectStmt));
		
		
	}
	
	protected function addHydrateOpen(&$script) {
		parent::addHydrateOpen($script);
		$newLine = "\n\t\t";
		
		$table = $this->getTable();
		$customDataColumn = $table->getColumn(self::KALTURA_COLUMN_CUSTOM_DATA);
		if($customDataColumn) {
			$script .= $newLine . "// Nullify cached objects";
			$script .= $newLine . "\$this->m_custom_data = null;" . $newLine;
		}
	}

	/* (non-PHPdoc)
	 * @see PHP5ObjectBuilder::addAlreadyInSaveAttribute($script)
	 */
	protected function addAlreadyInSaveAttribute(&$script)
	{
		$script .= "
	/**
	 * Flag to prevent endless save loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected \$alreadyInSave = false;

	/**
	 * Flag to indicate if save action actually affected the db.
	 * @var        boolean
	 */
	protected \$objectSaved = false;
";
	}


	/* (non-PHPdoc)
	 * @see PHP5ObjectBuilder::addSave($script)
	 */
	protected function addSave(&$script)
	{
		parent::addSave($script);
		
		$script .= "	
	public function wasObjectSaved()
	{
		return \$this->objectSaved;
	}
";
	}
	
	/* (non-PHPdoc)
	 * @see PHP5ObjectBuilder::addSaveBody($script)
	 */
	protected function addSaveBody(&$script) {
		$table = $this->getTable();
		if (!$table->containsColumn(self::KALTURA_COLUMN_CUSTOM_DATA))
			return parent::addSaveBody($script);
		$reloadOnUpdate = $table->isReloadOnUpdate();
		$reloadOnInsert = $table->isReloadOnInsert();
		$customDataColumn = $table->getColumn(self::KALTURA_COLUMN_CUSTOM_DATA);

		$script .= "
		if (\$this->isDeleted()) {
			throw new PropelException(\"You cannot save an object that has been deleted.\");
		}

		if (\$con === null) {
			\$con = Propel::getConnection(".$this->getPeerClassname()."::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		\$con->beginTransaction();
		\$isInsert = \$this->isNew();
		try {";
		
		if($this->getGeneratorConfig()->getBuildProperty('addHooks')) {
			// save with runtime hools
			$script .= "
			\$ret = \$this->preSave(\$con);";
			$this->applyBehaviorModifier('preSave', $script, "			");
			$script .= "
			if (\$isInsert) {
				\$ret = \$ret && \$this->preInsert(\$con);";
			$this->applyBehaviorModifier('preInsert', $script, "				");
			$script .= "
			} else {
				\$ret = \$ret && \$this->preUpdate(\$con);";
			$this->applyBehaviorModifier('preUpdate', $script, "				");
			$script .= "
			}
			
			if (!\$ret || !\$this->isModified()) {
				\$con->commit();
				return 0;
			}
			
			for (\$retries = 1; \$retries < KalturaPDO::SAVE_MAX_RETRIES; \$retries++)
			{
               \$affectedRows = \$this->doSave(\$con);
                if (\$affectedRows || !\$this->isColumnModified(".$this->getPeerClassname()."::CUSTOM_DATA)) //ask if custom_data wasn't modified to avoid retry with atomic column 
                	break;

                KalturaLog::debug(\"was unable to save! retrying for the \$retries time\");
                \$criteria = \$this->buildPkeyCriteria();
				\$criteria->addSelectColumn(".$this->getPeerClassname()."::CUSTOM_DATA);
                \$stmt = BasePeer::doSelect(\$criteria, \$con);
                \$cutsomDataArr = \$stmt->fetchAll(PDO::FETCH_COLUMN);
                \$newCustomData = \$cutsomDataArr[0];

                \$this->custom_data_md5 = is_null(\$newCustomData) ? null : md5(\$newCustomData);

                \$valuesToChangeTo = \$this->m_custom_data->toArray();
				\$this->m_custom_data = myCustomData::fromString(\$newCustomData); 

				//set custom data column values we wanted to change to
				\$validUpdate = true;
				\$atomicCustomDataFields = ".$this->getPeerClassname()."::getAtomicCustomDataFields();
			 	foreach (\$this->oldCustomDataValues as \$namespace => \$namespaceValues){
                	foreach(\$namespaceValues as \$name => \$oldValue)
					{
						\$atomicField = false;
						if(\$namespace) {
							\$atomicField = array_key_exists(\$namespace, \$atomicCustomDataFields) && in_array(\$name, \$atomicCustomDataFields[\$namespace]);
						} else {
							\$atomicField = in_array(\$name, \$atomicCustomDataFields);
						}
						if(\$atomicField) {
							\$dbValue = \$this->m_custom_data->get(\$name, \$namespace);
							if(\$oldValue != \$dbValue) {
								\$validUpdate = false;
								break;
							}
						}
						
						\$newValue = null;
						if (\$namespace)
						{
							if (isset (\$valuesToChangeTo[\$namespace][\$name]))
								\$newValue = \$valuesToChangeTo[\$namespace][\$name];
						}
						else
						{ 
							\$newValue = \$valuesToChangeTo[\$name];
						}
		
						if (is_null(\$newValue)) {
							\$this->removeFromCustomData(\$name, \$namespace);
						}
						else {
							\$this->putInCustomData(\$name, \$newValue, \$namespace);
						}
					}
				}
                   
				if(!\$validUpdate) 
					break;
					                   
				\$this->setCustomData(\$this->m_custom_data->toString());
			}

			if (\$isInsert) {
				\$this->postInsert(\$con);";
			$this->applyBehaviorModifier('postInsert', $script, "					");
			$script .= "
			} else {
				\$this->postUpdate(\$con);";
			$this->applyBehaviorModifier('postUpdate', $script, "					");
			$script .= "
			}
			\$this->postSave(\$con);";
			$this->applyBehaviorModifier('postSave', $script, "				");
			$script .= "
			".$this->getPeerClassname()."::addInstanceToPool(\$this);
			
			\$con->commit();
			return \$affectedRows;";
		} else {
			// save without runtime hooks
	    $this->applyBehaviorModifier('preSave', $script, "			");
			if ($this->hasBehaviorModifier('preUpdate'))
			{
			  $script .= "
			if(!\$isInsert) {";
	      $this->applyBehaviorModifier('preUpdate', $script, "				");
	      $script .= "
			}";
			}
			if ($this->hasBehaviorModifier('preInsert'))
			{
			  $script .= "
			if(\$isInsert) {";
	    	$this->applyBehaviorModifier('preInsert', $script, "				");
	      $script .= "
			}";
			}
			$script .= "
			\$affectedRows = \$this->doSave(\$con".($reloadOnUpdate || $reloadOnInsert ? ", \$skipReload" : "").");";
	    $this->applyBehaviorModifier('postSave', $script, "			");
			if ($this->hasBehaviorModifier('postUpdate'))
			{
			  $script .= "
			if(!\$isInsert) {";
	      $this->applyBehaviorModifier('postUpdate', $script, "				");
	      $script .= "
			}";
			}
			if ($this->hasBehaviorModifier('postInsert'))
			{
			  $script .= "
			if(\$isInsert) {";
	      $this->applyBehaviorModifier('postInsert', $script, "				");
	      $script .= "
			}";
			}
			$script .= "
			\$con->commit();
			".$this->getPeerClassname()."::addInstanceToPool(\$this);
			return \$affectedRows;";
		}
		
		$script .= "
		} catch (PropelException \$e) {
			\$con->rollBack();
			throw \$e;
		}";
	}
	
	/* (non-PHPdoc)
	 * @see PHP5ObjectBuilder::addDoSave($script)
	 */
	protected function addDoSave(&$script)
	{
		$table = $this->getTable();

		$reloadOnUpdate = $table->isReloadOnUpdate();
		$reloadOnInsert = $table->isReloadOnInsert();

		$script .= "
	/**
	 * Performs the work of inserting or updating the row in the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All related objects are also updated in this method.
	 *
	 * @param      PropelPDO \$con";
		if ($reloadOnUpdate || $reloadOnInsert) {
			$script .= "
	 * @param      boolean \$skipReload Whether to skip the reload for this object from database.";
		}
		$script .= "
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        save()
	 */
	protected function doSave(PropelPDO \$con".($reloadOnUpdate || $reloadOnInsert ? ", \$skipReload = false" : "").")
	{
		\$affectedRows = 0; // initialize var to track total num of affected rows
		if (!\$this->alreadyInSave) {
			\$this->alreadyInSave = true;
";
		if ($reloadOnInsert || $reloadOnUpdate) {
			$script .= "
			\$reloadObject = false;
";
		}

		if (count($table->getForeignKeys())) {

			$script .= "
			// We call the save method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.
";

			foreach ($table->getForeignKeys() as $fk)
			{
				$aVarName = $this->getFKVarName($fk);
				$script .= "
			if (\$this->$aVarName !== null) {
				if (\$this->".$aVarName."->isModified() || \$this->".$aVarName."->isNew()) {
					\$affectedRows += \$this->".$aVarName."->save(\$con);
				}
				\$this->set".$this->getFKPhpNameAffix($fk, $plural = false)."(\$this->$aVarName);
			}
";
			} // foreach foreign k
		} // if (count(foreign keys))
		
		if ($table->hasAutoIncrementPrimaryKey() ) {
		$script .= "
			if (\$this->isNew() ) {
				\$this->modifiedColumns[] = " . $this->getColumnConstant($table->getAutoIncrementPrimaryKey() ) . ";
			}";
		}

		$script .= "

			// If this object has been modified, then save it to the database.
			\$this->objectSaved = false;
			if (\$this->isModified()";

		$script .= ") {
				if (\$this->isNew()) {
					\$pk = ".$this->getPeerClassname()."::doInsert(\$this, \$con);";
		if ($reloadOnInsert) {
			$script .= "
					if (!\$skipReload) {
						\$reloadObject = true;
					}";
		}
		$script .= "
					\$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).
";
		if ($table->getIdMethod() != IDMethod::NO_ID_METHOD) {

			if (count($pks = $table->getPrimaryKey())) {
				foreach ($pks as $pk) {
					if ($pk->isAutoIncrement()) {
						$script .= "
					\$this->set".$pk->getPhpName()."(\$pk);  //[IMV] update autoincrement primary key
";
					}
				}
			}
		} // if (id method != "none")

		$script .= "
					\$this->setNew(false);
					\$this->objectSaved = true;
				} else {";
		if ($reloadOnUpdate) {
			$script .= "
					if (!\$skipReload) {
						\$reloadObject = true;
					}";
		}
		$script .= "
					\$affectedObjects = ".$this->getPeerClassname()."::doUpdate(\$this, \$con);
					if(\$affectedObjects)
						\$this->objectSaved = true;
						
					\$affectedRows += \$affectedObjects;
				}
";

		// We need to rewind any LOB columns
		foreach ($table->getColumns() as $col) {
			$clo = strtolower($col->getName());
			if ($col->isLobType()) {
				$script .= "
				// Rewind the $clo LOB column, since PDO does not rewind after inserting value.
				if (\$this->$clo !== null && is_resource(\$this->$clo)) {
					rewind(\$this->$clo);
				}
";
			}
		}

		$script .= "
				\$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}
";

		foreach ($table->getReferrers() as $refFK) {

			if ($refFK->isLocalPrimaryKey()) {
				$varName = $this->getPKRefFKVarName($refFK);
				$script .= "
			if (\$this->$varName !== null) {
				if (!\$this->{$varName}->isDeleted()) {
						\$affectedRows += \$this->{$varName}->save(\$con);
				}
			}
";
			} else {
				$collName = $this->getRefFKCollVarName($refFK);
				$script .= "
			if (\$this->$collName !== null) {
				foreach (\$this->$collName as \$referrerFK) {
					if (!\$referrerFK->isDeleted()) {
						\$affectedRows += \$referrerFK->save(\$con);
					}
				}
			}
";
			} // if refFK->isLocalPrimaryKey()

		} /* foreach getReferrers() */
		$script .= "
			\$this->alreadyInSave = false;
";
		if ($reloadOnInsert || $reloadOnUpdate) {
			$script .= "
			if (\$reloadObject) {
				\$this->reload(\$con);
			}
";
		}
		$script .= "
		}
		return \$affectedRows;
	} // doSave()
";

	}
	
	/**
	 * Adds the save hook methods.
	 * @param      string &$script The script will be modified in this method.
	 */
	protected function addSaveHooks(&$script)
	{
		$table = $this->getTable();
		$createdAtColumn = $table->getColumn(self::KALTURA_COLUMN_CREATED_AT);
		$updatedAtColumn = $table->getColumn(self::KALTURA_COLUMN_UPDATED_AT);
		$customDataColumn = $table->getColumn(self::KALTURA_COLUMN_CUSTOM_DATA);
		$reloadOnInsert = $table->isReloadOnInsert();
		
		$script .= "
	/**
	 * Override in order to use the query cache.
	 * Cache invalidation keys are used to determine when cached queries are valid.
	 * Before returning a query result from the cache, the time of the cached query
	 * is compared to the time saved in the invalidation key.
	 * A cached query will only be used if it's newer than the matching invalidation key.
	 *  
	 * @return     array Array of keys that will should be updated when this object is modified.
	 */
	public function getCacheInvalidationKeys()
	{
		return array();
	}
		
	/**
	 * Code to be run before persisting the object
	 * @param PropelPDO \$con
	 * @return boolean
	 */
	public function preSave(PropelPDO \$con = null)
	{";
		if($customDataColumn)
		$script .= "
		\$this->setCustomDataObj();
    	";
		
		$script .= "
		return parent::preSave(\$con);
	}

	/**
	 * Code to be run after persisting the object
	 * @param PropelPDO \$con
	 */
	public function postSave(PropelPDO \$con = null) 
	{
		kEventsManager::raiseEvent(new kObjectSavedEvent(\$this));
		\$this->oldColumnsValues = array();";
		
		if($customDataColumn)
		$script .= "
		\$this->oldCustomDataValues = array();
    	";
				
		$script .= " 
		parent::postSave(\$con);
	}
	
	/**
	 * Code to be run before inserting to database
	 * @param PropelPDO \$con
	 * @return boolean
	 */
	public function preInsert(PropelPDO \$con = null)
	{";
		
		if($createdAtColumn)
		$script .= "
		\$this->setCreatedAt(time());";
		
		if($updatedAtColumn)
		$script .= "
		\$this->setUpdatedAt(time());";
		
		$script .= "
		return parent::preInsert(\$con);
	}
	";

		$script .= "
	/**
	 * Code to be run after inserting to database
	 * @param PropelPDO \$con 
	 */
	public function postInsert(PropelPDO \$con = null)
	{
		kQueryCache::invalidateQueryCache(\$this);
		";
		
		if ($this->shouldRaiseEvents())
		{
			$script .= "
		kEventsManager::raiseEvent(new kObjectCreatedEvent(\$this));
		
		if(\$this->copiedFrom)
			kEventsManager::raiseEvent(new kObjectCopiedEvent(\$this->copiedFrom, \$this));
		";
		}
		$script .= "
		parent::postInsert(\$con);
	}

	/**
	 * Code to be run after updating the object in database
	 * @param PropelPDO \$con
	 */
	public function postUpdate(PropelPDO \$con = null)
	{
		if (\$this->alreadyInSave)
		{
			return;
		}
	";
		if ($this->shouldRaiseEvents())
		{
			$script .= "
		if(\$this->isModified())
		{
			kQueryCache::invalidateQueryCache(\$this);
			\$modifiedColumns = \$this->tempModifiedColumns;";
			
			if($customDataColumn) {
				$script .= "
			\$modifiedColumns[kObjectChangedEvent::CUSTOM_DATA_OLD_VALUES] = \$this->oldCustomDataValues;";
			}
			
			$script .= "
			kEventsManager::raiseEvent(new kObjectChangedEvent(\$this, \$modifiedColumns));
		}
			
		\$this->tempModifiedColumns = array();
		";
		}
		else
		{
			$script .= "
		kQueryCache::invalidateQueryCache(\$this);
		";
		}
		$script .= "
		parent::postUpdate(\$con);
	}";
	
	if ($this->isDeletable())
	{
	    $script .= "
	    
	/**
	 * Code to be run after deleting the object from database
	 * @param PropelPDO \$con
	 */
	public function postDelete(PropelPDO \$con = null)
	{
		kQueryCache::invalidateQueryCache(\$this);
		
		";
		if ($this->shouldRaiseEvents())
		{
			$script .= "
		kEventsManager::raiseEvent(new kObjectErasedEvent(\$this));
		";
		}
		$script .= "
		parent::postDelete(\$con);
	}
	";
	}	
		if(!$this->shouldRaiseEvents())
			return;
	
		$script .= "
	/**
	 * Saves the modified columns temporarily while saving
	 * @var array
	 */
	private \$tempModifiedColumns = array();
	
	/**
	 * Returns whether the object has been modified.
	 *
	 * @return     boolean True if the object has been modified.
	 */
	public function isModified()
	{
		if(!empty(\$this->tempModifiedColumns))
			return true;
			
		return !empty(\$this->modifiedColumns);
	}

	/**
	 * Has specified column been modified?
	 *
	 * @param      string \$col
	 * @return     boolean True if \$col has been modified.
	 */
	public function isColumnModified(\$col)
	{
		if(in_array(\$col, \$this->tempModifiedColumns))
			return true;
			
		return in_array(\$col, \$this->modifiedColumns);
	}

	/**
	 * Code to be run before updating the object in database
	 * @param PropelPDO \$con
	 * @return boolean
	 */
	public function preUpdate(PropelPDO \$con = null)
	{
		if (\$this->alreadyInSave)
		{
			return true;
		}	
		";
		
		if($updatedAtColumn)
		$script .= "
		
		if(\$this->isModified())
			\$this->setUpdatedAt(time());";
		
		$script .= "
		
		\$this->tempModifiedColumns = \$this->modifiedColumns;
		return parent::preUpdate(\$con);
	}
	";
		
	}
	
	/**
	 * Adds the copy() method, which (in complex OM) includes the $deepCopy param for making copies of related objects.
	 * @param      string &$script The script will be modified in this method.
	 */
	protected function addCopy(&$script)
	{
		$this->addCopyInto($script);

		$table = $this->getTable();

		$script .= "
	/**
	 * Makes a copy of this object that will be inserted as a new row in table when saved.
	 * It creates a new object filling in the simple attributes, but skipping any primary
	 * keys that are defined for the table.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      boolean \$deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @return     ".$this->getObjectClassname()." Clone of current object.
	 * @throws     PropelException
	 */
	public function copy(\$deepCopy = false)
	{
		// we use get_class(), because this might be a subclass
		\$clazz = get_class(\$this);
		" . $this->buildObjectInstanceCreationCode('$copyObj', '$clazz') . "
		\$this->copyInto(\$copyObj, \$deepCopy);
		\$copyObj->setCopiedFrom(\$this);
		return \$copyObj;
	}
	
	/**
	 * Stores the source object that this object copied from 
	 *
	 * @var     ".$this->getObjectClassname()." Clone of current object.
	 */
	protected \$copiedFrom = null;
	
	/**
	 * Stores the source object that this object copied from 
	 *
	 * @param      ".$this->getObjectClassname()." \$copiedFrom Clone of current object.
	 */
	public function setCopiedFrom(".$this->getObjectClassname()." \$copiedFrom)
	{
		\$this->copiedFrom = \$copiedFrom;
	}
";
	} // addCopy()
	
	/**
	 * Specifies the methods that are added as part of the basic OM class.
	 * This can be overridden by subclasses that wish to add more methods.
	 * @see        ObjectBuilder::addClassBody()
	 */
	protected function addClassBody(&$script)
	{
		parent::addClassBody($script);
		
		$table = $this->getTable();
		$customDataColumn = $table->getColumn(self::KALTURA_COLUMN_CUSTOM_DATA);
		if($customDataColumn)
			$this->addCustomDataMethods($script);
	}

	/**
	 * Adds the mutator open body part
	 * @param      string &$script The script will be modified in this method.
	 * @param      Column $col The current column.
	 * @see        addMutatorOpen()
	 **/
	protected function addMutatorOpenBody(&$script, Column $col) 
	{
		parent::addMutatorOpenBody($script, $col);
		
		$clo = strtolower($col->getName());
		
		if(in_array($clo, self::$systemColumns))
			return;
			
		$fullColumnName = $this->getColumnConstant($col);
		$script .= "
		if(!isset(\$this->oldColumnsValues[$fullColumnName]))
			\$this->oldColumnsValues[$fullColumnName] = \$this->$clo;
";
	}
	

	/**
	 * Adds a setter method for date/time/timestamp columns.
	 * @param      string &$script The script will be modified in this method.
	 * @param      Column $col The current column.
	 * @see        parent::addColumnMutators()
	 */
	protected function addTemporalMutator(&$script, Column $col)
	{
		$cfc = $col->getPhpName();
		$clo = strtolower($col->getName());
		$visibility = $col->getMutatorVisibility();

		$dateTimeClass = $this->getBuildProperty('dateTimeClass');
		if (!$dateTimeClass) {
			$dateTimeClass = 'DateTime';
		}

		$script .= "
	/**
	 * Sets the value of [$clo] column to a normalized version of the date/time value specified.
	 * ".$col->getDescription()."
	 * @param      mixed \$v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     ".$this->getObjectClassname()." The current object (for fluent API support)
	 */
	".$visibility." function set$cfc(\$v)
	{";
		
		$this->addMutatorOpenBody($script, $col);

		$fmt = var_export($this->getTemporalFormatter($col), true);

		$script .= "
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if (\$v === null || \$v === '') {
			\$dt = null;
		} elseif (\$v instanceof DateTime) {
			\$dt = \$v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric(\$v)) { // if it's a unix timestamp
					\$dt = new $dateTimeClass('@'.\$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					\$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					\$dt = new $dateTimeClass(\$v);
				}
			} catch (Exception \$x) {
				throw new PropelException('Error parsing date/time value: ' . var_export(\$v, true), \$x);
			}
		}

		if ( \$this->$clo !== null || \$dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			\$currNorm = (\$this->$clo !== null && \$tmpDt = new $dateTimeClass(\$this->$clo)) ? \$tmpDt->format($fmt) : null;
			\$newNorm = (\$dt !== null) ? \$dt->format($fmt) : null;

			if ( (\$currNorm !== \$newNorm) // normalized values don't match ";

		if (($def = $col->getDefaultValue()) !== null && !$def->isExpression()) {
			$defaultValue = $this->getDefaultValueString($col);
			$script .= "
					|| (\$dt->format($fmt) === $defaultValue) // or the entered value matches the default";
		}

		$script .= "
					)
			{
				\$this->$clo = (\$dt ? \$dt->format($fmt) : null);
				\$this->modifiedColumns[] = ".$this->getColumnConstant($col).";
			}
		} // if either are not null
";
		$this->addMutatorClose($script, $col);
	}
	
	
	/**
	 * Adds all custom data required methods
	 * @param      string &$script The script will be modified in this method.
	 */
	protected function addCustomDataMethods(&$script)
	{
		$table = $this->getTable();

		$script .= "
	/* ---------------------- CustomData functions ------------------------- */

	/**
	 * @var myCustomData
	 */
	protected \$m_custom_data = null;
	
	/**
	 * The md5 value for the custom_data field.
	 * @var        string
	 */
	protected \$custom_data_md5;

	/**
	 * Store custom data old values before the changes
	 * @var        array
	 */
	protected \$oldCustomDataValues = array();
	
	/**
	 * @return array
	 */
	public function getCustomDataOldValues()
	{
		return \$this->oldCustomDataValues;
	}
	
	/**
	 * @param string \$name
	 * @param string \$value
	 * @param string \$namespace
	 * @return string
	 */
	public function putInCustomData ( \$name , \$value , \$namespace = null )
	{
		\$customData = \$this->getCustomDataObj( );
		
		\$customDataOldValue = \$customData->get(\$name, \$namespace);
		if(!is_null(\$customDataOldValue) && serialize(\$customDataOldValue) === serialize(\$value))
			return;
				
		\$currentNamespace = '';
		if(\$namespace)
			\$currentNamespace = \$namespace;
			
		if(!isset(\$this->oldCustomDataValues[\$currentNamespace]))
			\$this->oldCustomDataValues[\$currentNamespace] = array();
		if(!isset(\$this->oldCustomDataValues[\$currentNamespace][\$name]))
			\$this->oldCustomDataValues[\$currentNamespace][\$name] = \$customDataOldValue;
		
		\$customData->put ( \$name , \$value , \$namespace );
	}

	/**
	 * @param string \$name
	 * @param string \$namespace
	 * @param string \$defaultValue
	 * @return string
	 */
	public function getFromCustomData ( \$name , \$namespace = null , \$defaultValue = null )
	{
		\$customData = \$this->getCustomDataObj( );
		\$res = \$customData->get ( \$name , \$namespace );
		if ( \$res === null ) return \$defaultValue;
		return \$res;
	}

	/**
	 * @param string \$name
	 * @param string \$namespace
	 */
	public function removeFromCustomData ( \$name , \$namespace = null)
	{
		\$customData = \$this->getCustomDataObj();
		
		\$currentNamespace = '';
		if(\$namespace)
			\$currentNamespace = \$namespace;
			
		if(!isset(\$this->oldCustomDataValues[\$currentNamespace]))
			\$this->oldCustomDataValues[\$currentNamespace] = array();
		if(!isset(\$this->oldCustomDataValues[\$currentNamespace][\$name]))
			\$this->oldCustomDataValues[\$currentNamespace][\$name] = \$customData->get(\$name, \$namespace);
		
		return \$customData->remove ( \$name , \$namespace );
	}

	/**
	 * @param string \$name
	 * @param int \$delta
	 * @param string \$namespace
	 * @return string
	 */
	public function incInCustomData ( \$name , \$delta = 1, \$namespace = null)
	{
		\$customData = \$this->getCustomDataObj( );
		
		\$currentNamespace = '';
		if(\$namespace)
			\$currentNamespace = \$namespace;
			
		if(!isset(\$this->oldCustomDataValues[\$currentNamespace]))
			\$this->oldCustomDataValues[\$currentNamespace] = array();
		if(!isset(\$this->oldCustomDataValues[\$currentNamespace][\$name]))
			\$this->oldCustomDataValues[\$currentNamespace][\$name] = \$customData->get(\$name, \$namespace);
		
		return \$customData->inc ( \$name , \$delta , \$namespace  );
	}

	/**
	 * @param string \$name
	 * @param int \$delta
	 * @param string \$namespace
	 * @return string
	 */
	public function decInCustomData ( \$name , \$delta = 1, \$namespace = null)
	{
		\$customData = \$this->getCustomDataObj(  );
		return \$customData->dec ( \$name , \$delta , \$namespace );
	}

	/**
	 * @return myCustomData
	 */
	public function getCustomDataObj( )
	{
		if ( ! \$this->m_custom_data )
		{
			\$this->m_custom_data = myCustomData::fromString ( \$this->getCustomData() );
		}
		return \$this->m_custom_data;
	}
	
	/**
	 * Must be called before saving the object
	 */
	public function setCustomDataObj()
	{
		if ( \$this->m_custom_data != null )
		{
			\$this->custom_data_md5 = is_null(\$this->custom_data) ? null : md5(\$this->custom_data);
			\$this->setCustomData( \$this->m_custom_data->toString() );
		}
	}
	
	/* ---------------------- CustomData functions ------------------------- */
	";
		
	} // addCustomDataMethods()

	/* (non-PHPdoc)
	 * @see PHP5ObjectBuilder::addBuildPkeyCriteriaClose($script)
	 */
	protected function addBuildPkeyCriteriaClose(&$script) 
	{
		$table = $this->getTable();
		if(!$table->getColumn(self::KALTURA_COLUMN_UPDATED_AT))
			return parent::addBuildPkeyCriteriaClose($script);
			
		$script .= "
		
		if(\$this->alreadyInSave)
		{";
		if ($table->containsColumn(self::KALTURA_COLUMN_CUSTOM_DATA)){	
			$script .= "
			if (\$this->isColumnModified(".$this->getPeerClassname()."::CUSTOM_DATA))
			{
				if (!is_null(\$this->custom_data_md5))
					\$criteria->add(".$this->getPeerClassname()."::CUSTOM_DATA, \"MD5(cast(\" . ".$this->getPeerClassname()."::CUSTOM_DATA . \" as char character set latin1)) = '\$this->custom_data_md5'\", Criteria::CUSTOM);
					//casting to latin char set to avoid mysql and php md5 difference
				else 
					\$criteria->add(".$this->getPeerClassname()."::CUSTOM_DATA, NULL, Criteria::ISNULL);
			}
			";	
		}
		$script .= "
			if (count(\$this->modifiedColumns) == 2 && \$this->isColumnModified(".$this->getPeerClassname()."::UPDATED_AT))
			{
				\$theModifiedColumn = null;
				foreach(\$this->modifiedColumns as \$modifiedColumn)
					if(\$modifiedColumn != ".$this->getPeerClassname()."::UPDATED_AT)
						\$theModifiedColumn = \$modifiedColumn;
						
				\$atomicColumns = ".$this->getPeerClassname()."::getAtomicColumns();
				if(in_array(\$theModifiedColumn, \$atomicColumns))
					\$criteria->add(\$theModifiedColumn, \$this->getByName(\$theModifiedColumn, BasePeer::TYPE_COLNAME), Criteria::NOT_EQUAL);
			}
		}		

		return \$criteria;
	}
";
	}
}