<?php

/**
 * Base abstraction for realtime calculated integer value 
 * @package Core
 * @subpackage model.data
 */
abstract class kIntegerField extends kIntegerValue implements IScopeField
{
	/**
	 * @var hScope
	 */
	protected $scope = null;
	
	/**
	 * Calculates the value at realtime
	 * @param hScope $scope
	 * @return int $value
	 */
	abstract protected function getFieldValue(hScope $scope = null);
	
	/* (non-PHPdoc)
	 * @see kIntegerValue::getValue()
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
	 * @see kIntegerValue::shouldDisableCache()
	 */
	public function shouldDisableCache($scope)
	{
		return true;
	}
}
