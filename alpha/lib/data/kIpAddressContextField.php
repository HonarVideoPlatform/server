<?php

/**
 * Returns the current request IP address context 
 * @package Core
 * @subpackage model.data
 */
class kIpAddressContextField extends hStringField
{
	/* (non-PHPdoc)
	 * @see kIntegerField::getFieldValue()
	 */
	protected function getFieldValue(hScope $scope = null)
	{
		kApiCache::addExtraField(kApiCache::ECF_IP);

		if(!$scope)
			$scope = new hScope();

		return $scope->getIp();
	}

	/* (non-PHPdoc)
	 * @see hStringValue::shouldDisableCache()
	 */
	public function shouldDisableCache($scope)
	{
		return false;
	}
}
