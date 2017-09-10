<?php
/**
 * @package Core
 * @subpackage model.data
 * @abstract
 */
abstract class kCondition 
{
	/**
	 * @var int ConditionType
	 */
	protected $type;
	
	/**
	 * @var string
	 */
	protected $description;
	
	/**
	 * @var bool
	 */
	protected $not = false;

	public function __construct($not = false)
	{
		$this->setNot($not);
	}
	
	/**
	 * Enable changing the condition attributes according to additional data in the scope
	 */
	protected function applyDynamicValues(hScope $scope)
	{
	}
	
	/**
	 * @param hScope $scope
	 * @return bool
	 */
	abstract protected function internalFulfilled(hScope $scope);
	
	/**
	 * @param hScope $scope
	 * @return bool
	 */
	final public function fulfilled(hScope $scope)
	{
		$this->applyDynamicValues($scope);
		return $this->calcNot($this->internalFulfilled($scope));
	}
	
	/**
	 * @return int ConditionType
	 */
	public function getType() 
	{
		return $this->type;
	}

	/**
	 * @param int $type ConditionType
	 */
	protected function setType($type) 
	{
		$this->type = $type;
	}

	/**
	 * @return string $description
	 */
	public function getDescription() 
	{
		return $this->description;
	}

	/**
	 * @param string $description
	 */
	public function setDescription($description) 
	{
		$this->description = $description;
	}
	
	/**
	 * @return bool
	 */
	public function getNot() 
	{
		return $this->not;
	}

	/**
	 * @param bool $not
	 */
	public function setNot($not) 
	{
		$this->not = $not;
	}

	/**
	 * Calculates the NOT operator
	 * @param bool
	 * @return bool
	 */
	private function calcNot($value) 
	{
		return $this->not ? !$value : $value;
	}

	/**
	 * @param hScope $scope
	 * @return bool
	 */
	public function shouldDisableCache($scope)
	{
		return true;
	}
}
