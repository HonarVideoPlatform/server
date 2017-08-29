<?php

/**
 * Base abstraction for realtime calculated string value 
 * @package Core
 * @subpackage model.data
 */
abstract class hStringField extends hStringValue implements IScopeField
{
	/**
	 * @var hScope
	 */
	protected $scope = null;
	
	/**
	 * Calculates the value at realtime
	 * @param hScope $scope
	 * @return string $value
	 */
	abstract protected function getFieldValue(hScope $scope = null);
	
	/* (non-PHPdoc)
	 * @see hStringValue::getValue()
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
	 * @see hStringValue::shouldDisableCache()
	 */
	public function shouldDisableCache($scope)
	{
		return true;
	}
}
