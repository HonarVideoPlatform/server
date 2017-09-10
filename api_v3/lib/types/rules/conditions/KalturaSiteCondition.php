<?php

/**
 * @package api
 * @subpackage objects
 */
class KalturaSiteCondition extends KalturaMatchCondition
{
	/**
	 * Init object type
	 */
	public function __construct() 
	{
		$this->type = ConditionType::SITE;
	}
	
	/* (non-PHPdoc)
	 * @see KalturaObject::toObject()
	 */
	public function toObject($dbObject = null, $skip = array())
	{
		if(!$dbObject)
			$dbObject = new hSiteCondition();
			
		return parent::toObject($dbObject, $skip);
	}
}
