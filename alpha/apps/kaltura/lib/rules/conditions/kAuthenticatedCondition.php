<?php
/**
 * @package Core
 * @subpackage model.data
 */
class kAuthenticatedCondition extends kCondition
{
	/* (non-PHPdoc)
	 * @see kCondition::__construct()
	 */
	public function __construct($not = false)
	{
		$this->setType(ConditionType::AUTHENTICATED);
		parent::__construct($not);
	}
	
	/**
	 * The privelege needed to remove the restriction
	 * 
	 * @var array
	 */
	protected $privileges = array(hs::PRIVILEGE_VIEW, hs::PRIVILEGE_VIEW_ENTRY_OF_PLAYLIST);
	
	/**
	 * @param array $privileges
	 */
	public function setPrivileges(array $privileges)
	{
		$this->privileges = $privileges;
	}
	
	/**
	 * @return array
	 */
	function getPrivileges()
	{
		return $this->privileges;
	}
	
	/* (non-PHPdoc)
	 * @see kCondition::internalFulfilled()
	 */
	protected function internalFulfilled(hScope $scope)
	{
		if (!$scope->getHs() || (!$scope->getHs() instanceof hs))
			return false;
		
		if ($scope->getHs()->isAdmin())
			return true;
		
		KalturaLog::debug(print_r($this->privileges, true));
		foreach($this->privileges as $privilege)
		{
			if(is_object($privilege))
				$privilege = $privilege->getValue();
				
			KalturaLog::debug("Checking privilege [$privilege] with entry [".$scope->getEntryId()."]");
			if($scope->getHs()->verifyPrivileges($privilege, $scope->getEntryId()))
			{
				KalturaLog::debug("Privilege [$privilege] verified");
				return true;
			}
		}

		KalturaLog::debug("No privilege verified");
		return false;
	}

	/* (non-PHPdoc)
	 * @see kCondition::shouldDisableCache()
	 */
	public function shouldDisableCache($scope)
	{
		// the HS type and privileges are part of the cache key
		return false;
	}
}
