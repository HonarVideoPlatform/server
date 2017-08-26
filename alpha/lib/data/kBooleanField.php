<?php

/**
 * Base abstraction for realtime calculated boolean value 
 * @package Core
 * @subpackage model.data
 */
abstract class kBooleanField extends kBooleanValue implements IScopeField
{
	/**
	 * @var hScope
	 */
	protected $scope = null;
	
	/**
	 * Calculates the value at realtime
	 * @param hScope $scope
	 * @return bool $value
	 */
	abstract protected function getFieldValue(hScope $scope = null);
	
	/* (non-PHPdoc)
	 * @see kBooleanValue::getValue()
	 */
	public function getValue() 
	{
		return $this->getFieldValue($this->scope);
	}
	
	/**
	 * @param hScope $scope
	 */
	public function setScope(hScope $scope) 
	{
		$this->scope = $scope;
	}

	/* (non-PHPdoc)
	 * @see kBooleanField::shouldDisableCache()
	 */
	public function shouldDisableCache($scope)
	{
		return true;
	}
}
