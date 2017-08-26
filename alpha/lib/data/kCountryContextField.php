<?php

/**
 * Return the current request country context as calculated based on the IP address 
 * @package Core
 * @subpackage model.data
 */
class kCountryContextField extends hStringField
{
	/**
	 * The ip geo coder engine to be used
	 * 
	 * @var int of enum geoCoderType
	 */
	protected $geoCoderType = geoCoderType::KALTURA;
	
	/* (non-PHPdoc)
	 * @see kIntegerField::getFieldValue()
	 */
	protected function getFieldValue(hScope $scope = null)
	{
		kApiCache::addExtraField(kApiCache::ECF_COUNTRY);

		if(!$scope)
			$scope = new hScope();
			
		$ip = $scope->getIp();
		$ipGeo = kGeoCoderManager::getGeoCoder($this->getGeoCoderType());
		$country = $ipGeo->getCountry($ip);
		return trim(strtolower($country), " \n\r\t");
	}
	
	/**
	 * @param int $geoCoderType of enum geoCoderType
	 */
	public function setGeoCoderType($geoCoderType)
	{
		$this->geoCoderType = $geoCoderType;
	}
	
	/**
	 * @return array
	 */
	function getGeoCoderType()
	{
		return $this->geoCoderType;
	}

	/* (non-PHPdoc)
	 * @see hStringValue::shouldDisableCache()
	 */
	public function shouldDisableCache($scope)
	{
		return false;
	}
}
