<?php
/**
 * @package Core
 * @subpackage model.data
 */
class kFieldMatchCondition extends kMatchCondition
{
	/**
	 * The field to evaluate against the values
	 * @var hStringField
	 */
	private $field;

	/* (non-PHPdoc)
	 * @see kCondition::__construct()
	 */
	public function __construct($not = false)
	{
		$this->setType(ConditionType::FIELD_MATCH);
		parent::__construct($not);
	}
	
	/* (non-PHPdoc)
	 * @see kMatchCondition::getFieldValue()
	 */
	public function getFieldValue(hScope $scope)
	{
		$this->field->setScope($scope);
		return $this->field->getValue();
	}
	
	/**
	 * @return hStringField
	 */
	public function getField() 
	{
		return $this->field;
	}

	/**
	 * @param hStringField $field
	 */
	public function setField(hStringField $field) 
	{
		$this->field = $field;
	}

	/* (non-PHPdoc)
	 * @see kMatchCondition::shouldFieldDisableCache()
	 */
	public function shouldFieldDisableCache($scope)
	{
		return $this->field->shouldDisableCache($scope);
	}	
}
