<?php

/**
 * Returns the current request user agent 
 * @package Core
 * @subpackage model.data
 */
class kUserAgentContextField extends hStringField
{
	/* (non-PHPdoc)
	 * @see hStringField::getFieldValue()
	 */
	protected function getFieldValue(hScope $scope = null) 
	{
		kApiCache::addExtraField(kApiCache::ECF_USER_AGENT);

		if(!$scope)
			$scope = new hScope();
			
		return $scope->getUserAgent();
	}

	/* (non-PHPdoc)
	 * @see hStringValue::shouldDisableCache()
	 */
	public function shouldDisableCache($scope)
	{
		return false;
	}
}